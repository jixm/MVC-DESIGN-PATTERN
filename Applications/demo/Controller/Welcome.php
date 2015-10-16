<?php
use System\Common\Functions as Y;
use xhprof\Debug;
class WelcomeController extends System\Core\Control{

	public function init(){
		Y::enableView();
		$this->setViewPath(VIEW);
	}

	public function sayAction(){
		// echo ROOT.'SITE/'.SITE;
		// Debug::enable();
		$name = $_GET['name'];
		$action = $_GET['action'];
		$this->assign('name',$name);
		$this->assign('action',$action);
		$this->assign('a','test');
		// Debug::disable();
		// $this->display();
	}

	public function walkAction(){
		
		$this->assign('a','hello **');
		// echo $this->render('say');
		$this->display('say');
	}

}