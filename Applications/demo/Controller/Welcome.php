<?php
use System\Common\Functions as Y;
use System\Core\Request as R;
use Db\Pdo;
class WelcomeController extends System\Core\Control{

	public function init(){
		Y::enableView();
		$this->setViewPath(VIEW);
	}

	public function sayAction(){
		// echo ROOT.'SITE/'.SITE;
		// Debug::enable();
		$page = R::get('page',1);
		Y::dump($page);
		$db = DB::test();
		// // Pdo->
		// // Y::dump($db);exit;
		$data = $db->createSql('select * from article')->query()->fetch();
		$this->aa();
		// WelcomeModel::getNotice();
		// $name = R::get('name');
		// $action   = R::get('action');
		// // Y::dump($action);exit;
		// $this->assign('name',$name);
		// $this->assign('action',$action);
		// $this->assign('a','test');
		// Debug::disable();
		// $this->display();
	}


	public function aa(){
	}

	public function walkAction(){
		
		$this->assign('a','hello **');
		// echo $this->render('say');
		$this->display('say');
	}

}