<?php
/**
 * some example of react js
 * @author : xm_hithd@163.com
 * @date : 2015-10-29
 */
use System\Core\Request as R;
use System\Common\Functions as Y;
class ReactController extends System\Core\Control{


	public function init(){
		Y::enableView();
		$this->setViewPath(VIEW);
	}



	//组件
	public function componentAction(){
		$this->display();
	}


	public function jsxAction(){
		$this->display();
	}

	public function jsxextendAction(){
		$this->display();
	}

	public function proptypesAction(){
		$this->display();
	}

	public function domAction(){
		$this->display();
	}

	public function statusAction(){
		$this->display();
	}

	public function lifecycleAction(){
		$this->display();
	}

	public function formAction(){
		$this->display();
	}	

}