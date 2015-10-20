<?php 
namespace System\Core;
use System\Common\Functions as Y;
use \Rule;
class Request {
    public static function get($name,$default = NULL) {
        $value = NULL;
        if ( array_key_exists( $name, Y::getParams() ) ) {
            $value =  Y::getParams( $name );
        } else {
            $params = $_GET;
            if ( array_key_exists( $name, $params ) ) {
                $value =  $params[$name];
            }
        } 
        if (!self::validate('get_'.$name,$value) || is_null($value)){
            $value = $default;
        }
        return  $value;

    }

    public static function post($name,$default = NULL) {
        $value = NULL;
        $params = $_POST;
        if ( array_key_exists( $name, $params ) ) {
            $value =  $params[$name];
        }
        if (!self::validate('post_'.$name,$value) || is_null($value)){
            $value = $default;
        }
        return  $value;

    }

    public static function cookie($name,$default = NULL) {
        $value = NULL;
        $params = $_COOKIE;
        if ( array_key_exists( $name, $params ) ) {
            $value =  $params[$name];
        }
        if (!self::validate('cookie_'.$name,$value) || is_null($value)){
            $value = $default;
        }
        return  $value;
    }

    public static function validate($name,$value) {
        if ( method_exists( "Rule", $name ) ) {
            return Rule::$name()->validate($value);
        }
        return  false;

    }

}
