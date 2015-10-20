<?php

namespace System\Core;
use System\Common\Functions as Y;
class View{

	public $vars = array();

	public $path;

	public $file;

	public function fetch( $template = ''){
		$this->file = $this->getTemplateFile($template);
        if(file_exists($this->file)) {
        	return $this->file;
        }else{
        	trigger_error('加载 ' . $this->file . ' 模板不存在');
        }

	}

	public function getTemplateFile($template = '') {
		$file = Y::getControl();
		if($template) {
			if(strpos($template,'Views')!=false) {
				return $template;
			}
			$file .= $template;
		}else{
			$file  .= Y::getAction();
		}
		return $this->path.$file.'.'.Y::get('ext');
	}






}