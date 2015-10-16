<?php
namespace petite;
use System\Common\Functions as Y;
class Autoload{

	protected static $_path;

	protected static $_class;

	public static function setPath($path){
		self::$_path = $path;
	}

	public static function included($name){
		if(isset(self::$_class[$name])){
			require_once(self::$_class[$name]);
			if(class_exists($name,false)){
				return true;
			}
		}
		return false;
	}

	public static function autoload($name){
	
		$classPath = str_replace('\\',DIRECTORY_SEPARATOR,$name);
		
		if(isset(self::$_class[$name])){
		
			self::included($name);

		}
		if(preg_match('/(\w+)?(Controller|Model)$/',$classPath,$match)){
			switch($match[2]){
				case 'Controller':
					$classFile = APP_PATH.$match[1].'.php';
					break;
				case 'Model':
					$classFile = MODEL.$match[1].'.php';
					break;
			}
			
		}else{

			if(strpos( $name ,'System\\' ) === 0 ) {

				$classFile = ROOT.$classPath.'.php';
			}else{
				$classFile = LIB.$classPath.'.php';
			}

		}

		if(!file_exists($classFile)){
			throw new \Exception('** class '.$name.' not found **');
		}

		
		self::$_class[$name] = $classFile;	

		self::included($name);
	}
}
spl_autoload_register('petite\Autoload::autoload');
