<?php
/**
 * set const
 * 
 */ 
define('VIEW',ROOT_PATH.'views/'.SITE."/");
define('LIB',ROOT_PATH.'library/');
define('APPLICATION',ROOT_PATH.'Applications/'.SITE.'/');
/*
 定义常量  
 some code ...

*/
date_default_timezone_set('Asia/Shanghai');
//设置session名
ini_set("session.name","/");
//设置session作用域
ini_set('session.cookie_domain', '/');
//防止cookie被恶意修改
ini_set('session.cookie_httponly',1);
//强制cookie存放sessionid
ini_set('session.use_only_cookies',1);
//禁止读取远程数据
ini_set('allow_url_fopen',0);
//禁止载入远程数据
ini_set('allow_url_include',0);
ini_set('zend.script_encoding','UTF8');

