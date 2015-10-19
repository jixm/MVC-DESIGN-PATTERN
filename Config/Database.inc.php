<?php
/**
 * database 配置文件   mysql redis memcache
 * 
 */
return 

array(

	'mysql_test' => array(
			'host' => '127.0.0.1' ,
            'port' => 3306 ,
            'user' => 'root' ,
            'password' => '' ,
            'database' => 'test' ,
            'persistent' => 0 ,
            'charset' => 'utf8'
		),
	'pdo_test' => array(
			'host' => '127.0.0.1' ,
            'port' => 3306 ,
            'user' => 'roots' ,
            'password' => '' ,
            'database' => 'test' ,
            'persistent' => 0 ,
            'charset' => 'utf8'
		),

	'redis_demo' => array(


		),


);
 