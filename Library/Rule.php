<?php
use Respect\Validation\Validator as v;
class Rule {
	
	 public static function get_name(){
        $validator = v::stringType();
        return $validator;
    }

    public static function get_action(){
        $validator = v::numeric();
        return $validator;
    }
}