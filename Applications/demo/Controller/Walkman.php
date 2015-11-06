<?php
/**
 * 集成workman 使用方法
 * 
 *  php index.php request_uri='walkman/start' start
 */
use Workerman\Worker;
use System\Common\Functions as Y;
use System\Core\Request as R;
class WalkmanController extends System\Core\Control{

	public function startAction(){
		$worker = new Worker('tcp://0.0.0.0:1234');
		$worker->count = 2;
		$worker->onMessage = array($this,'onMessage');
		$worker->onConnect = array($this,'onConnect');
		$worker->onWorkerStart = array($this,'onWorkerStart');
		$worker->runAll();
	}

	public function onMessage($connection,$data){
			Y::dump($data);
	}

	public function onConnect($connection){
		Y::dump("************************** conneciton ****************************");
	}

	public function onWorkerStart($worker){
		Y::dump("************************** worker start ****************************");
	}
}