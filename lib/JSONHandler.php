<?php
namespace BigMonster\Core\JSON;

include_once(join(array(LIBDIR,'StringClass.php')));
/**
{
"Updated": "01.22.2010",
"Author": "Clay Campbell",
"Type": "Object",
"Object": "JSONHandler",
"Parent": "StringClass",
"Name": "JSONHandler",
"Description": "Wrapper for PHP 5.3+ built in JSON methods"
}
**/


class JSONHandler extends \Bigmonster\Core\StringClass{

	public $dataObj,$jsonObj;

	function __construct(){

		parent::__construct();

		$this->jsonObj = 
		$this->dataObj = NULL;
	}

	public function encode(){

		if(empty($this->dataObj)){ return false; }

		$this->jsonObj = json_encode($this->dataObj);

		return true;
	}

	public function decode(){

		$this->dataObj = json_decode($this->jsonObj);
	}

	public function decodeAry(){

		return json_decode($this->jsonObj,true);
	}
}
?>
