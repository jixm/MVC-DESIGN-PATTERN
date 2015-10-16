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
		$this->whiteList();
		$control = new $ctrlClass();
		$action  = self::getActionName();
		if (!method_exists($control, $action)) {
			exit("Action: does not have method `$action`");
		}
		$control->$action();
		
	}

	public  function parseRoute( $path ) {
		if( !$path ) return ;
		$urlQuery = parse_url( $path , PHP_URL_QUERY );
		$urlPath  = trim(parse_url( $path , PHP_URL_PATH ),'/');
		$pathArr  = explode( '/' , $urlPath );
		$module   = MODULE.ucfirst($pathArr[0]).'/Controller';

		if( file_exists( $module )) {
			self::$module = ucfirst($pathArr[0]);
			if($pathArr[1] ) 
				self::$control = ucfirst($pathArr[1]);
			if($pathArr[2])
				self::$action  = $pathArr[2];

		}else{
			if($pathArr[0])
				self::$control = ucfirst($pathArr[0]);
			if($pathArr[1])
				self::$action  = $pathArr[1];
		}
		if($urlQuery){
			$params = strtr($urlQuery,array('&'=>'/','='=>'/'));
		}else{
			
			$params = substr($urlPath,stripos($urlPath,self::$action )+strlen(self::$action) );
		}
		$this->dealParams($params);

	}
	
	public function dealParams($params){
		if(!$params) return ;
		$params = explode( '/' , trim($params,'/'));
		if( count($params) % 2 != 0 ){
			trigger_error('参数不正确',E_USER_ERROR);
		}
		foreach($params as $key => $val) {
			if($key%2==0){
				self::$params[$val] = $params[$key+1];
			}
		}
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

	// public function setAutoLoadPath(){
	// 	$ctrlPath = $this->getModulePath().'Controller/';
	// 	\petite\Autoload::setPath($ctrlPath);
	// }

	public function getModulePath(){
		return self::$module=='Index'?APP:MODULE;
	}

	//路由处理
    public  function whiteList() {

        $modules = $this->getModulePath();

        // Y::dump($modules);

        // $m = $request->module;
        // $c = $request->controller;
        // $a = $request->action;
        // if ( array_key_exists( $m , $modules ) ) {
        //     if ( array_key_exists( $c , $modules[$m] ) ) {
        //         if ( in_array( $a , $modules[$m][$c] ) ) {
        //             //self::dump($request,$modules,$modules[$m]);
        //             return true;
        //         }
        //     }
        // }
        // if ( NODEBUG ) {
        //     self::reRoute( 'Index' , 'Error' , 'whiteList' );
        // } else {
        //     throw new \Exception("请检查控制器是否写入配置文件{$m}-{$c}-{$a}");
        // }

    }


}