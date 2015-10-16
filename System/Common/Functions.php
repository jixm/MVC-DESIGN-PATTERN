<?php

namespace System\Common;
use System\Core\Config;
use System\Core\Route;
use System\Core\Control;
class Functions{
        
  	public static function dump() {
          $argv = func_get_args();
          if ( self::isCli() ) {
              $hr = str_pad( '' , 40 , "=" );
                  echo "\n";
                  foreach ($argv as $arg) {
                      var_dump( $arg );
                      echo $hr;
                  }
                  echo "\n";
              } else {
                  echo '<pre><br>';
                  foreach ($argv as $arg) {
                      var_dump( $arg );
                      echo '<hr>';
                  }
                  echo '</pre>';
          }


      }

    public static function isCli(){
    	if( 'cli' == strtolower(php_sapi_name()) ){
    		return true;
    	}
    	return false;
    }

    public static function getClientIp() {
         $ipaddress = '0.0.0.0';
          if (array_key_exists('HTTP_CLIENT_IP', $_SERVER))
              $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
          else if(array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER))
              $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
          else if(array_key_exists('HTTP_X_FORWARDED', $_SERVER))
              $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
          else if(array_key_exists('HTTP_FORWARDED_FOR', $_SERVER))
              $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
          else if(array_key_exists('HTTP_FORWARDED', $_SERVER))
              $ipaddress = $_SERVER['HTTP_FORWARDED'];
          else if(array_key_exists('REMOTE_ADDR', $_SERVER))
              $ipaddress = $_SERVER['REMOTE_ADDR'];
          return $ipaddress; 
      }



    public static function web(){

    }

    public static function cli(){

    }

    public static function getParams(){
       return Route::$params;
    }

    public static function disableView(){
        Control::disableView();
    }

    public static function enableView(){
        Control::enableView();
    }

    // public static function request(){

    // }

    public static function set($name,$value){
        Config::set($name,$value);
    }
    public static function getControl(){
        return Route::$control.'/';
    }

    public static function getAction() {
        return Route::$action;
    }

    public static function getModule(){
        return Route::getModule();
    }

    public static function get( $name = ''){
        return config::get( $name );
    }

    public static function has( $name ){
        return config::has( $name );
    }

    

}