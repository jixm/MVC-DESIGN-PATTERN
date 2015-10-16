<?php
namespace System\Core;
use System\Common\Functions as Y;
use System\Core\Request;
abstract class Route{

	public static $module  = 'Index';

	public static $control = 'Home';

	public static $action  = 'index';

	public static $params  = array();

	public function __construct( $path ){
		Y::has( 'defaultMoude' )      && self::$module = Y::get( 'defaultModule' );
		Y::has( 'defaultController' ) && self::$control = Y::get( 'defaultController' );
		Y::has( 'defaultAction' )     && self::$action = Y::get( 'defaultAction' );
		$this->parseRoute($path);
	}

	//路由分发
	public  function dispatch() {
		$ctrlFile = $this->getCtrlFile();
		$ctrlClass = $this->getCtrlClass();

		$this->whiteList($control);
		
		$control = new $ctrlClass();

	
		$action  = self::getActionName();
		
		$control->$action();
		
	}

	public  function parseRoute( $path ) {
		if( !$path ) return ;
		$urlQuery = parse_url( $path , PHP_URL_QUERY );
		$urlPath  = trim(parse_url( $path , PHP_URL_PATH ),'/');
		$pathArr  = explode( '/' , $urlPath );
		$module   = APP.ucfirst($pathArr[0]).'/Controller';
		if( file_exists( $module )) {
			self::$module = ucfirst($pathArr[0]);
			if($pathArr[1] ) 
				self::$control = ucfirst($pathArr[1]);
			if($pathArr[2])
				self::$action  = $pathArr[2];
			$params = array_slice( $pathArr , 3 );

		}else{
			if($pathArr[0])
				self::$control = ucfirst($pathArr[0]);
			if($pathArr[1])
				self::$action  = $pathArr[1];
			$params = array_slice($pathArr,2);
		}
		if($urlQuery) {
		
			$params = $this->dealParams($urlQuery);
		}
		self::$params = $params;

	}
	
	public function dealParams($urlQuery){
		if(!$urlQuery) return ;
		$params    = array();
		$tmpParams = strtr($urlQuery,array('&'=>'/','='=>'/'));
		$tmpParams = explode( '/' , trim($tmpParams,'/'));
		if( count($tmpParams) % 2 != 0 ){
			trigger_error('参数不正确',E_USER_ERROR);
		}
		foreach($tmpParams as $key => $val) {
			if($key%2==0){
				$params[$val] = $tmpParams[$key+1];
			}
		}
		unset($tmpParams);
		return $params;
	}

	public  function getActionName(){
		return self::$action.'Action';
	}

	public static function getModule(){
		return self::$module;
	}
	
	public  function getCtrlClass(){
		if(!defined('APP_PATH')){
			define('APP_PATH',$this->getModulePath().'Controller/');
		}
		return self::$control.'Controller';
	}

	
	public function getCtrlFile() {
		return $this->getModulePath().'Controller/'.self::$control.'.php';
	}


	public function getModulePath(){
		return self::$module=='Index'?APP:APP.self::$module;
	}

	//路由是否合法
    public  function whiteList($controlObj) {
    	$msg = array();
        $modules = $this->getModulePath();
        $control = $this->getCtrlFile();
        $action  = $this->getActionName();
        if(!file_exists($control)){
        	$msg[] = '控制器'.$control.'不存在';
        }

        if(!method_exists($controlObj,$action)) {
        	$msg[] = '方法'.$action.'不存在';
        }
        if( $msg ) {
        	if( DEBUG ){
        		// throw new \Exception($msg[0]);
        		echo 1;exit;
        	}
        	$this->reRoute('Index','Error','whiteList');
        }

    }


}