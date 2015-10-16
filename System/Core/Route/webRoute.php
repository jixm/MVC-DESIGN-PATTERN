<?php
namespace System\Core\Route;
use System\Core\Route;
use System\Common\Functions as Y;
class webRoute extends Route {


	public function __construct(){
		$requestUri = trim(str_replace('index.php','',$_SERVER['REQUEST_URI']),'/');
		parent::__construct($requestUri);
	}


}