
**一个简单的MVC框架,代码逻辑很简单,主要是回顾下MVC的思想逻辑.简单说一下需要注意的点** 

###Workerman
集成了开源socket开发框架Workerman
```php
//命令行启动服务,项目入口执行 php index.php request_uri='walkman/start' start|restart|status
//example Controller/Walkman.php
<?php
use Workerman\Worker;
use System\Common\Functions as Y;
use System\Core\Request as R;
class WalkmanController extends System\Core\Control{

	public function startAction(){
		$worker = new Worker('tcp://0.0.0.0:1234');
		$worker->count = 2;
		$worker->onMessage = array($this,'onMessage');
		$worker->onConnect = array($this,'onConnect');
		$worker->onWorkerStart = array($this,'onWorkerStart');
		$worker->runAll();
	}

	public function onMessage($connection,$data){
			Y::dump($data);
			/*   
				业务逻辑

			*/
	}

	public function onConnect($connection){
		Y::dump("客户端连接时调用");
	}

	public function onWorkerStart($worker){
		Y::dump("服务启动时调用");
	}
}
```
###目录结构
>Public
>>project_name
>>>index.php  入口文件
>>>.htaccess   重写规则
			 
>Application
>>project_name

>>>Controller

>>>Model

>>>Module

>Config

>>project_name.inc.php  对应项目的配置文件


>Library  本地类库,自动加载

>System  核心类库

>Views    视图


###入口文件

```php
define('PUBLIC_PATH',__DIR__);      //当前项目入口路径

define('SITE','Demo');              //定义项目名,必须

require_once  '../../Autoload.php'; //加载类

require_once  '../../setting.php';  //常量定义,其他设置

new System\Core\Bootstrap();

```
###重写规则
```bash
server {
  listen ****;
  server_name  domain.com;
  root   document_root;
  index  index.php index.html index.htm;

  if (!-e $request_filename) {
    rewrite ^/(.*)  /index.php/$1 last;
  }

```

###配置文件
>Demo.inc.php 为数组形式做配置文件,命名方式:项目名.inc.php

>Database.inc.php 数据库配置文件为共用

>以上两个数组都会整合到统一静态变量形式存放,如下

```php
Y::get($name)  //$name为空返回整个配置数组,不为空返回对应key的值
```
###URI
支持两种url格式
- base_uri/key1/val1/key2/val2(这种形式参数获取必须用下面将要说到的形式R::get('key1'),$_GET是获取不到的)
- base_uri?key1=val1&key2/val2($_POST或者R::post('key1'))
- base_uri/key1/val1?key2/val2 这种形式key1,key2值也可以获取到,但没人会这么传参吧

>参数的获取最好还是采用R::get(),R::post形式,这种方式会对你定义的参数类型进行验证,严谨些好

###控制器
####GET,POST参数获取
```php
<?php
use System\Common\Functions as Y;
use System\Core\Request as R;

public function init() {
	//所有方法之前执行
	Y::enableView();//打开模板输出
	//Y::disableView();关闭模板输出
	$this->setViewPath(VIEW);//设置模版路径
}
public function testAction() {
	
	$name = R::get('name','jim'); //name为$_GET参数,如果没有获取到默认'jim'

	$id   = R::post('page',1);   //获取post

	$this->assign('name',$name);
	$this->assign('id',$id);
	$this->display();//默认当前项目/控制器/方法名 .php文件
	//echo $this->render();
	$this->display('edit');
}
```

同时在LIB目录Rule.php中要对参数进行定义(过滤验证)
```php
<?php
use Respect\Validation\Validator as v;
class Rule {
		
	//get参数
	public static function get_name(){
        $validator = v::stringType();
        return $validator;
    }
    //post来的参数
    public static function post_id(){
        $validator = v::numeric();
        return $validator;
    }

}
```
具体使用方法可以参考这个类库的说明[Respect](https://github.com/Respect/Validation)
####Model调用
Model定义和普通类没有区别,类名+Model
```php
<?php
class UserModel {
	public static function getUser() {
		/*
			some code...
		 */
	}
}

```
####数据库连接
1.首先在Config/Database.inc.php中定义mysql连接配置,格式 '类型(pdo|mysqli|mysql等)'+'实例名'
```php
<?php
return 
array(
	//这是一个通过pdo连接数据库,实例名为test的一个连接的配置,系统会根据所选的类型实例对应的数据库连接类,目前只有pdo
	'pdo_test' => array(
			'host' => '127.0.0.1' ,
            'port' => 3306 ,
            'user' => 'root' ,
            'password' => '' ,
            'database' => 'test' ,
            'persistent' => 0 ,
            'charset' => 'utf8'
		),

);
```
2.数据库连接,操作
```php
<?php
use \DB;
class UserModel {
	
	public static function getUserList() {

		//$db = DB::user('mysqli'); 通过mysqli连接数据库,如果为空默认已PDO方式,配置文件中要定义一个 mysqli_user的配置数组
		$db   = DB::user();
		$sql  = 'SELECT * from user where type=:type';  //pdo预处理
		$data = $db->createSql($sql)->query(array(':type'=>'hot'))->fetchAll();
		/*
			或者
			$reader = $db->createSql($sql)->query(array(':type'=>'hot'));
			while($tmpData = $reader->fetch()){
				$data[] = $tmpData; 
			}			
		 */ 
	}
	
}

```

###视图文件
视图结构
>Views
>>project_name
>>>Index(默认module)
>>>>控制器(folder)

VIEW/Demo/Index/Welcome/

```
<?php
use System\Common\Functions as Y;
$this->display(VIEW.'Index/Public/Header.php',array('nav'=>'this is nav'));//公共头

?>
<h1>i m content : <?php echo $name.$action?></h1>

<?php

$this->display(VIEW.'Index/Public/Footer.php');//包含公共尾

?>
```

###运行

###Tips
		





