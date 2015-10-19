<?php
/**
 * 以init开始的方法自动执行
 * 
 */
namespace System\Core;
use System\Common\Functions as Y;
use System\Core\Config;
use System\Core\Route\cliRoute;
use System\Core\Route\webRoute;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;
use xhprof\Debug;
class Bootstrap{

	public $pattern = '/^init/';



	public function __construct() {
		$methods = get_class_methods( $this );
		foreach( $methods as $method ){
			if( preg_match( $this->pattern , $method ) ){
				$this->$method();
			}
		}
	}

	/**
     * 初始化获取配置文件
     * @return void
     */
	public function initConfig() {
			
		config::init();
	}

	/**
	 * 禁止访问
	 * @return void
	 */
	public function initDeny() {
		$hostDeny = explode( ',' , config::get( 'host_deny' ) );
		$clientIp = Y::getClientIp();
		if( in_array( $clientIp , $hostDeny ) ) {
			header( 'HTTP/1.0 403 Forbidden' );
			die( 'No Permission' );
		}
	}

	/**
	 * 错误
	 * @return [type]     [description]
	 */
	public function initErr(){
		if( DEBUG ) {
			ini_set( 'display_errors' , 1 );
            error_reporting( E_ALL );
            $whoops  = new Run();
            $handler = new PrettyPageHandler();
            $whoops->pushHandler( $handler );
            $whoops->register();

		} else { 
			ini_set( 'display_errors' , 0 );
            error_reporting( 0 );
		}
		if(isset($_GET['debug']) && $_GET['debug'] == 'safe') {
		 	Debug::enable();
		}
	}

	/**
	 * 初始化路由
	 * @return [type]     [description]
	 */
	public function initRoute() {
		$isCli = Y::isCli();
		if( $isCli ) {
			$router = new cliRoute();
		} else {
			$router = new webRoute();
		}
		$router->dispatch();
	}
	
}