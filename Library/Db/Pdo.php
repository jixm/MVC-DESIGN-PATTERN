<?php


namespace Db;
use System\Common\Functions as Y;
// use \PDO;
use PDOException;
use PDOStatement;

class Pdo {
    public $config = array(
        'host' => '127.0.0.1' ,
        'port' => 3306 ,
        'user' => 'root' ,
        'password' => '' ,
        'database' => 'test' ,
        'charset' => 'utf8'
    );
    //链接数据库资源
    protected $connection;
    protected $stmt = array();
    //最后执行的sql语句
    public $lastSql;
    //定位字段
    protected $position;

    public function __construct( $config ) {
        $this->config = $config + $this->config;
        if ( !extension_loaded( 'pdo' ) ) {
            throw new \Exception("mysql模块未加载" , __FILE__ . ':' . __LINE__ . "行");
        }
        $dsn = "mysql:host={$this->config['host']};port={$this->config['port']};dbname={$this->config['database']};charset={$this->config['charset']}";
        try {
            if ( $this->config['persistent'] ) {
                $this->connection = new PDO($dsn , $this->config['user'] , $this->config['password'] , array(\PDO::ATTR_PERSISTENT => true));
            } else {
                $this->connection = new \PDO($dsn , $this->config['user'] , $this->config['password'],  array(\PDO::ATTR_PERSISTENT => false));
            }
            //自己写代码捕获Exception
            $this->connection->setAttribute( \PDO::ATTR_ERRMODE , \PDO::ERRMODE_EXCEPTION );
            //回复列的默认显示格式
            $this->connection->setAttribute( \PDO::ATTR_CASE , \PDO::CASE_NATURAL );

        } catch (PDOException $e) {
            $this->log( $e->getMessage() );
        }
    }

    /**
     * 执行sql
     *
     * @param null $params
     * @param int  $position
     *
     * @return $this|bool
     */
    public function query( $params = null , $position = 1 ) {

        if ( !empty($this->stmt[$position]) && $this->stmt[$position] instanceof PDOStatement ) {
            if ( !is_null( $params ) && is_array( $params ) ) {
                $this->bind( $params , $position );
            }

            $this->stmt[$position]->execute();

            return $this;
        }

        return false;
    }

    /**
     * 创建预处理sql
     *
     * @param     $sql
     * @param int $position
     *
     * @return $this
     */
    public function createSql( $sql , $position = 1 ) {
        $this->stmt[$position] = $this->connection->prepare( $sql );

        return $this;
    }

    /**
     * 游标方式获取数据
     * @param string $fetchAction
     * @param int    $position
     *
     * @return mixed
     */
    public function fetch( $fetchAction = "assoc" , $position = 1 ) {
        if ( !empty($this->stmt[$position]) && $this->stmt[$position] instanceof PDOStatement ) {
            $this->fetchAction( $fetchAction , $position );

            return $this->stmt[$position]->fetch();
        }

        return false;
    }

    /**
     * 获取全部信息
     * @param string $fetchAction
     * @param int    $position
     *
     * @return mixed
     */
    public function fetchAll( $fetchAction = "assoc" , $position = 1 ) {
        if ( !empty($this->stmt[$position]) && $this->stmt[$position] instanceof PDOStatement ) {
            $this->fetchAction( $fetchAction , $position );

            return $this->stmt[$position]->fetchAll();
        }

        return false;
    }

    /**
     * 返回影响行数，update,delete,insert    对select获取到的结果不能保证准确
     *
     * @param int $position
     *
     * @return int
     */
    public function rowCount( $position = 1 ) {
        if ( !empty($this->stmt[$position]) && $this->stmt[$position] instanceof PDOStatement ) {
            return $this->stmt[$position]->rowCount();
        }

        return 0;
    }

    /**
     * 获取最后插入的id
     *
     * @param string $name
     *
     * @return bool|string
     */
    public function lastInsertId( $name = "" ) {
        if ( !empty($this->connection) && $this->connection instanceof PDO ) {
            return $this->connection->lastInsertId( $name );
        }

        return false;
    }

    /**
     * 事务开始
     */
    public function beginTransaction() {
        $this->connection->beginTransaction();
    }

    /**
     * 事务提交
     */
    public function commit() {
        $this->connection->commit();
    }

    /**
     * 事务回滚
     */
    public function rollBack() {
        $this->connection->rollback();
    }

    /**
     * 设置获取数据的方式
     * @param     $fetchAction
     * @param int $position
     */
    private function fetchAction( $fetchAction , $position = 1 ) {

        switch ($fetchAction) {
            case "assoc":
                $get_fetch_action = \PDO::FETCH_ASSOC; //asso array
                break;
            case "num":
                $get_fetch_action = \PDO::FETCH_NUM; //num array
                break;
            case "object":
                $get_fetch_action = \PDO::FETCH_OBJ; //object array
                break;
            case "both":
                $get_fetch_action = \PDO::FETCH_BOTH; //assoc array and num array
                break;
            default:
                $get_fetch_action = \PDO::FETCH_ASSOC;
                break;
        }
        $this->stmt[$position]->setFetchMode( $get_fetch_action );
    }

    /**
     * 数据绑定
     * @param array $params
     * @param int   $position
     */
    private function bind( array $params , $position = 1 ) {

        $this->lastSql = $this->stmt[$position]->queryString;

        foreach ($params as $key => $val) {
            if ( strstr( $key , ":" ) === false ) {
                continue;
            }
            switch (gettype( $val )) {
                case "integer":
                    $type          = PDO::PARAM_INT;
                    $this->lastSql = str_replace( $key , $val , $this->lastSql );
                    break;
                case "boolean":
                    $type          = PDO::PARAM_BOOL;
                    $this->lastSql = str_replace( $key , $val , $this->lastSql );
                    break;
                case "NULL":
                    $type          = PDO::PARAM_NULL;
                    $this->lastSql = str_replace( $key , $val , $this->lastSql );
                    break;
                default:
                    $type          = PDO::PARAM_STR;
                    $this->lastSql = str_replace( $key , "'" . $val . "'" , $this->lastSql );
                    break;
            }

            $this->stmt[$position]->bindParam( $key , $params[$key] , $type );
        }
    }

    /**
     * 绑定错误
     * @param $error
     *
     * @throws \Exception
     */
    protected function log( $error ) {
        throw new \Exception($error);
    }
}