<?php

//-定义常量 公共
 
//dev 开发 product 正式
define('ENV','dev');
//是否开启调试模式
define( 'DEBUG' , true );
define( 'ROOT' , __DIR__ .'/');
define( 'APP' , ROOT.'Applications/'.SITE.'/' );
define( 'C' , APP.'Controller/' );
define( 'MODULE' , APP.'Module/' );
define( 'VIEW' , ROOT.'views/'.SITE.'/' );
define( 'LIB' , ROOT.'Library/' );
define( 'CONFIG' , ROOT.'config/');
define( 'MODEL' , APP.'model/' );

//-系统设置
date_default_timezone_set('Asia/Shanghai');
ini_set("session.name","/");
ini_set('session.cookie_domain', '/');
ini_set('session.cookie_httponly',1);
ini_set('session.use_only_cookies',1);
ini_set('allow_url_fopen',0);
ini_set('allow_url_include',0);
ini_set('zend.script_encoding','UTF8');
