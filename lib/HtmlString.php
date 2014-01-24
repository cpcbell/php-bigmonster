<?php
namespace Bigmonster\Core\Html;

include_once(join(array(LIBDIR,'StringClass.php')));

/**
{
"Updated": "05.10.2011",
"Author": "Clay Campbell",
"Type": "Object",
"Object": "HtmlString",
"Parent": "StringClass",
"Name": "HtmlString",
"Description": "Checks and builds strings. Decide if a new method being created here is better used in parent."
}
**/

class HtmlString extends \Bigmonster\Core\StringClass{

	function __construct(){

		parent::__construct();

	}

	// String manipulation

	function newLine2BR(){

		return nl2br($this->str);	
	}

	function otherToBr($str){

		return preg_replace('/\.\s+/',
			'<br>',
			$str);	
	}

	function removeHtml($str){

		return preg_replace('/<.*?>.*?<\/.*?>/',
			'',
			$str);	
	}

	function removeHtmlTags($str){

		return preg_replace('/<.*?>|<\/.*?>/',
			'',
			$str);	
	}

	function encodeStr($str){

		return htmlspecialchars($str, ENT_QUOTES,'UTF-8');
	}

	// String checks
		
	function isLink($str){

		if(preg_match_all('/(https?:\/\/\S+)/imS',$str,$this->matchAry,PREG_PATTERN_ORDER)){

			return true;	
		}

		return false;
	}

	function isImageLink($str){

		if(preg_match('/\.jpg|\.jpeg|\.png|\.gif|\.tif|\.tiff$/i',$str)){

			return true;	
		}

		return false;
	}
}

?>
