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

	public function onClose(){
		Y::dump("***************************on Close****************************");
	}

	//缓冲区写满时触发
	public function onBufferFull(){
		Y::dump("***************************on bufferfull****************************");
	}

	//例如在onBufferFull时停止向对端继续send数据，在onBufferDrain恢复写入数据。
	public function onBufferDrain(){
		Y::dump("***************************on BufferDrain****************************");
	}

	// /客户端的连接上发生错误时触发。
	public function onError(){
		Y::dump("***************************onError****************************");
	}
}