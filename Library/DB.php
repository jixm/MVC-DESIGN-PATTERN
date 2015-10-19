<?php
use System\Common\Functions as Y;
use System\Factory as F;
class DB {
	
	/**
	 * 获取数据库连接实例
	 * @author jixm 
	 * @date   2015-10-19
	 * @param  [type]     $name mysql配置项名
	 * @param  [type]     $type 类型mysql,pdo 或者mysqli
	 * @return [type]           [description]
	 */
	public static function getInstance($name,$type) {
		$dbConfig = Y::get($type.'_'.$name);
		return  F::getInstance('Db\\'.$type,$dbConfig);
	}

	public static function __callStatic($name,$type){
		$mysqlType = $type?$type:'pdo';
		return self::getInstance($name,$mysqlType);
	}
}