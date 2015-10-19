<?php
namespace System\Core;
use System\Core\View;
use System\Manager;
use System\Common\Functions as Y;
use xhprof\Debug;
class Control{

	protected $_view = NULL;

	protected $_autoshow = false;

	public function __construct(){
		$this->_view = new View();
		if(method_exists( $this , 'init' )){
			$this->init();
		}
	}

	public function setViewPath( $path ){
		$module = Y::getModule();
		$this->_view->path = $path.$module.'/';
	}

	protected function display($template=''){
		$this->isShow();
		echo $this->_view->fetch($template);
	}

	
	protected function render($template){
		return $this->_view->fetch($template);
	}

	protected function assign($name,$value){
		$this->_view->vars[$name] = $value;
	}
	
	protected function redirect(){
		
	}

	public static function enableView(){
		Y::set('tpShow',true);
	}

	public static function disableView(){

		Y::set('tpShow',false);
	
	}

	public function isShow() {
		//xhprof性能分析图片头部不能有输出,所以要屏蔽模版输出
		if( !Y::get( 'tpShow' ) || Y::getParams('debug') == 'safe') {
			exit ;
		}
	}

	public function __destruct() {
		if(Y::getParams('debug') && Y::getParams('debug')=='safe') {
			//开启xhprof
			Debug::disable();
		}
	}


	/*
		@todo
		redirect
		reRoute
	 */
	
}