<?php
use System\Core\Request as R;
use System\Common\Functions as Y;
class UserController extends System\Core\Control{
	
	public function init(){
		$this->setViewPath(VIEW);
	}

	public function LoginAction(){
		Y::dump(111111111111);
		$id   = R::post('id');
		var_dump($id);
	}
}