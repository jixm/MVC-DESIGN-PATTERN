<?php

namespace System\Core\Route;
use System\Core\Route;

class cliRoute extends Route {
	
	public function __construct() {
		global $argv;
		if(isset($argv[1]) && $argv[1]){
			if(preg_match('/request_uri/',$argv[1])){
				$uri = substr($argv[1],12);
			}else{
				echo 'be sure params is right';exit;
			}
		}else{
			echo 'lack of params';exit;
		}
		if(isset($argv[2])){
			$_GET = $argv[2];
		}
		parent::__construct($uri);
	}
}