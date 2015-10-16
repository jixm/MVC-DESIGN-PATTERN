<?php
namespace System\Core;
use System\Core\View;
use System\Manager;
use System\Common\Functions as Y;
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
		$this->_autoshow = true;
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
		if( !Y::get( 'tpShow' ) ) {
			exit ;
		}
	}
	public function __destruct() {
		$this->isShow();
		if(!$this->_autoshow) {
			$this->_view->fetch();
		}
	}
}