<?php

namespace System\Core;

class Config{
	
	public static $config = array();

	public static $db = array();

	public static function init() {
		$db = include CONFIG.'Database.inc.php';
		self::$config = include CONFIG.SITE.'.inc.php';
		foreach( $db as $name => $val ) {
			self::$config[$name] = $val;
		}
	}

	public static function get( $name ) {

		if( $name ) {
			if( isset( self::$config[$name] ) ) {
				return self::$config[$name];
			}
			throw new \Exception('配置'.$name.'不存在');
			// return null;
		}
		return self::$config; 
	}	

	public static function set( $name , $value ) {
		if( $value != false && empty( $value ) ) {
			throw new \Exception('值不要为空');
		}
		self::$config[$name] = $value;

	}

	public static function delete( $name ) {
		if( isset( self::$config[$name] ) ) {
			unset( self::$config[$name] );
			return true; 
		}
		return false;
	}

	public static function has( $name ) {
		if( isset( self::$config[$name] ) && !empty( self::$config[$name] ) ) {
			return true;
		}
		return false;
	}

	

}