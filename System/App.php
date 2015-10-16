<?php
/**
 * 	执行流程 初始化配置文件解析request
 */
namespace System;
use System\Common\Functions as Y;
use System\Core\Route;
class App{

	public static $config;

	public static function run(){
		
		// self::parseConfig();
		

		if( Y::isCli() ){
			// cli 模式
		}else{
			// web模式
		}	
		// Route::dispach();

	}

	public static function parseConfig(){
		//@Todo 解析配置文件
	}

	public static function initRequest(){
		//解析request
	}


}