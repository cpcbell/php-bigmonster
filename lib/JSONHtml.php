<?php
namespace BigMonster\Core\Html;

include_once(join(array(LIBDIR,'HtmlElement.php')));
include_once(join(array(LIBDIR,'JSONHandler.php')));

/**
{
"Updated": "08.23.2011",
"Author": "Clay Campbell",
"Type": "Object",
"Object": "JSONHtml",
"Parent": "HtmlElement",
"Name": "JSONHtml",
"Description": "Build HTML using JSON data"
}
**/

class JSONHtml extends HtmlElement{

	public $dataObj;

	function __construct(){

		parent::__construct();

		$this->jsonObj =
		$this->dataObj = NULL;

		$this->jsonObj = new \Bigmonster\Core\JSON\JSONHandler();
	}

	public function jsonToHtml(){

		if(empty($this->dataObj)){ return false; }

		$this->jsonObj->jsonObj = $this->dataObj;

		$this->loopAry = $this->jsonObj->decodeAry();

		$this->htmlLoop();

	}

	protected function htmlLoop(){

		$ct = count($this->loopAry);

		for($a=0;$a<$ct;$a++){

			$this->resetAttributes();
			$this->attributeAry = array_merge($this->attributeAry,$this->loopAry[$a]);	
			$this->htmlElement();
		}
	}

	public function htmlElement(){

		if(array_key_exists('method',$this->attributeAry)){

			if(method_exists($this,$this->attributeAry['method'])){

				$method = $this->attributeAry['method'];
				$this->attributeAry['method'] = null;

				if(array_key_exists('parameter',$this->attributeAry)){

					$parameter = $this->attributeAry['parameter'];
					$this->attributeAry['parameter'] = null;
					return $this->{$method}($parameter);	
				}
				
				return $this->{$method}();	

			}
			$this->attributeAry['method'] = null;
		}
		
		return parent::htmlElement();
	}
}
?>
