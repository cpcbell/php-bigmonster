<?php
namespace BigMonster\Core{

/**
{
"Updated": "10.26.2010",
"Author": "Clay Campbell",
"Type": "Object",
"Object": "StringClass",
"Parent": "N/A",
"Name": "StringClass",
"Description": "Builds generic strings, should be super efficient."
}
**/

class StringClass{

	public $str;

	public $finalStr;

	public $cast;

	public $castFinal;

	public $ary;

	public $finalAry;

	public $joinStr;

	public $callbackMethod;

	function __construct(){

		$this->str = 
			$this->finalStr = 
			$this->joinStr = 
			$this->callbackMethod = null;

		$this->cast = 
		$this->castFinal = false;

		$this->ary =  
			$this->finalAry = array();
	}

	// takes an array and transforms it running  
	//   a callback method on each element 
	//
	protected function aryCallback(){

		if(isset($this->ary[0]) === false){ return false; }

		$this->finalStr = null;

		if($this->runCallback() === false){ return false; }

		return true;
	}

	// use array_map to modify each elements value using a callback method
	// would be nice to use a callBackClass instead of $this reference
	//
	protected function runCallback(){

		$this->finalAry = array();
		$this->finalAry = array_map(array(&$this,$this->callbackMethod),$this->ary);
	}

	// this provides a place to do final actions
	// like cast to str if needed
	//
	protected function finalStr(){ 

		if($this->castFinal){ $this->castFinal(); }

		return $this->finalStr; 
	}

	protected function castFinal(){

		$this->finalStr = (string) $this->finalStr;
	}

	function cast(){

		$this->str = (string) $this->str;
	}

	function callbackAryToStr(){

		$this->aryCallback();

		$this->finalStr = join($this->joinStr,$this->finalAry);
		return $this->finalStr();
	}

	function aryToStr(){

		$this->finalStr = join($this->joinStr,$this->ary);
		return $this->finalStr();
	}

	function md5Sum(){

		$this->finalStr = hash('md5',$this->str);
		return $this->finalStr();
	}

	function chopStr($chopInt=2){

        $this->finalStr = substr($this->str, 0, $chopInt);
		return $this->finalStr();
    }

	function toUpper($str=null){

		if($str !== null){ $this->str = $str; }

		$this->finalStr = strtoupper($this->str);
		return $this->finalStr();
	}

	function toLower(){

		$this->finalStr = strtolower($this->str);
		return $this->finalStr();
	}

	function randomLetterString($len=8){

		$ary = array();

		while($len){

			$ary[] = chr(mt_rand(97,122));
			--$len;
		}

		$this->finalStr = join($ary); 

		return $this->finalStr();
	}

	function base64Encode(){

		$this->finalStr = base64_encode($this->str);
		return $this->finalStr();
	}

	function base64Decode(){

		$this->finalStr = base64_decode($this->str);
		return $this->finalStr();
	}

	
	// Checks that return boolean 
	//
	function isString(){

		return is_string($this->str);
	}

	function isEmpty(){

		return ($this->str === '') ? true : false;
	}

	function isZero(){

		return ($this->str === '0') ?  true : false;
	}

	// if the parameter exists in the str let us know
	//
	function inStr($str){

		return (strpos($this->str,$str) !== false) ? true : false;
	}

	// prepare a pattern string for special characters
	// this is used when converting 
	//
	function specialCharacterPattern($str){

		$patternAry = array(
				'/\//',
				'/\./',
				'/\?/',
				'/\*/',
				'/\(/',
				'/\+/',
				'/\|/',
				'/\^/',
				'/\[/',
				'/\]/',
				'/\$/'
				);
		$replaceAry = array(
				'\/',
				'\.',
				'\?',
				'\*',
				'\(',
				'\+',
				'\|',
				'\^',
				'\[',
				'\]',
				'\$'
				);

		$ary = array('/',
			preg_replace($patternAry,$replaceAry,$str),
			'/'
			);

		return join($ary);
	}
// class end
}
// NS end 
}
?>
