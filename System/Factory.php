<?php
namespace system;
use System\Common\Functions as Y;
class Factory{
	protected static $instances;

	public static function getInstance($className, $params = null){

        if (isset(self::$instances[$className])) {
            return self::$instances[$className];
        }
        if (empty($params)) {
            self::$instances[$className] = new $className();
        } else {
            self::$instances[$className] = new $className($params);
        }
        return self::$instances[$className];
    }

}