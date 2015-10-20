<?php
namespace System\Core;
use System\Core\View;
use System\Core\Route\webRoute;
use System\Manager;
use System\Common\Functions as Y;
use xhprof\Debug;
class Control{

	protected $_view = NULL;

	protected $_vars = array();


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

	protected function display($template='',$assigns = array()){
		$this->isShow();
		if($assigns){
			$this->_vars = $assigns;
		}
		$this->fetch($template);
	}

	
	protected function render( $template = '' , $assigns = array()){
		if($assigns){
			$this->_vars = $assigns;
		}
		$this->fetch($template,false);
	}

	public function fetch($template,$out = true) {
		$file = $this->_view->fetch($template);
		extract($this->_vars);
        ob_start();
        include $file;
        $content = ob_get_contents();
        ob_end_clean();
        if($out === true) {
        	echo $content;
        }else{
        	return $content;
        }
	}

	protected function assign($name,$value){
		$this->_vars[$name] = $value;
	}
	
	
	/**
	 * 跳转
	 * @author jixm 
	 * @date   2015-10-20
	 * @param  string     $control 控制器
	 * @param  string     $action  方法
	 * @param  array      $params  参数
	 * @return [type]              
	 */
	protected function redirect($control='',$action='',$params=array(),$return=false){
		if($action) {
			$uri = ($control?$control.'/':Y::getControl()).$action;
		}else{
			$uri = ($control?$control.'/':Y::getControl()).'Index';
		}
		if($return===true) return $uri;
		$location = Y::getHost().$uri;
		if($params){
			$location.='?'.http_build_query($params);
		}
		header("Location: $location");
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