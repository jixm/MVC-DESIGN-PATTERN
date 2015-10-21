<?php
use System\Common\Functions as Y;
use System\Core\Request as R;
use Db\Pdo;
class WelcomeController extends System\Core\Control{

	public function init(){
		// Y::enableView();
		$this->setViewPath(VIEW);
	}

	public function sayAction(){
		$string = "博";
		for ($i = 0; $i < strlen($string); $i++) {
		    echo dechex(ord($string[$i]));
		}



		// $db = DB::test();
		// $data = $db->createSql('select * from article')->query()->fetch();
		// WelcomeModel::getNotice();
		// $name = R::get('name','name');
		// $action   = R::get('action','action');
		// $this->assign('name',$name);
		// $this->assign('action',$action);
		// $this->display();
		// $this->render();
	}


	public function aa(){
	}

	public function walkAction(){
		
		$this->assign('a','hello **');
		// echo $this->render('say');
		$this->display('say');
	}

}