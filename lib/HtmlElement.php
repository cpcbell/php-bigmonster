<?php
namespace Bigmonster\Core\Html;

include_once(join(array(LIBDIR,'HtmlString.php')));

/**
{
"Version": "3.0",
"Updated": "08.21.2011",
"Author": "Clay Campbell",
"Type": "Object",
"Object": "HtmlElement",
"Parent": "HtmlString",
"Name": "HtmlElement",
"Description": "Builds HTML, should be super efficient."
}
**/


class HtmlElement extends HtmlString{

	// these are dep in this fork
	public $dataStr,
		$elementName,
		$encode,
		$close,
		$break;

	public $htmlElementAry,
		$elementAry,
		$elementNameAry, 
		$cssAry,
		$jsAry,
		$attributeAry,
		$singleAttributeAry,
		$htmlAttributeAry;

	function __construct(){

		parent::__construct();

		$this->htmlElementAry =
		$this->htmlAttributeAry =
		$this->singleAttributeAry = 
		$this->elementAry = 
		$this->jsAry = 
		$this->cssAry = array(); 

		$this->elementName = 
		$this->dataStr = null; 

		$this->newLine = true;
		$this->close = true; 

		$this->encode =
			$this->break = false;

		$this->resetAttributes();
	}

	function resetAttributes(){

		$this->attributeAry = array(
			'id'=>null,
			'class'=>null,
			'style'=>null,
			'title'=>null,
			'name'=>null,
			'value'=>null,
			'type'=>null,
			'tabindex'=>null,
			'element'=>null,
			'replay'=>null,
			'close'=>true,
			'encode'=>false,
			'dataStr'=>null
			);

		return true;
	}

	function load($ary){

		$this->attributeAry = array_merge($this->attributeAry,$ary);
	}

	function comment($str){

		$this->htmlElementAry[] = join(array("\n",
		 	'<!--',	
		 	$str,
		 	'-->',
		 	"\n"
			));
	}

	// for now this will always return the 4.01 strict.dtd
	//   and start the head tag, since these things will not have attributes
	//   it will also write the mandatory TITLE element
	//
	function html($title='This page needs a title'){

		$str = join(array('<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"',
   			'"http://www.w3.org/TR/html4/loose.dtd">',
			"\n",
			'<html>',
			"\n",
			'<head>',
			"\n",
			'<title>',
			$title,
			'</title>',
			"\n",
			));

		$this->htmlElementAry = array($str);

		return $str;
	}

	function contentTypeMeta($content='text/html; charset=UTF-8'){

		return $this->httpEquivMeta('Content-Type',$content);
	}
	
	function httpEquivMeta($name,$content){

		$ary = array(
			'http-equiv'=>$name,
			'content'=>$content
			);

		$this->attributeAry = array_merge($this->attributeAry,$ary);

		return $this->meta();
	}

	/**
		how fast is array_merge?  faster than setting manually?
	*/
	function nameMeta($name,$content,$lang='en-us'){

		$this->attributeAry['name'] = $name;
		$this->attributeAry['content'] = $content;
		$this->attributeAry['lang'] = $lang;

		return $this->meta();
	}

	// build a META element
	//
	protected function meta(){

		$this->attributeAry['element'] = 'meta'; 
		$this->attributeAry['close'] = false; 
		/*
		$this->elementName = $this->elementNameAry['meta'];
		$this->close = false;
		*/

		return $this->htmlElement(true);
	}


	// build favicon link element
	//
	function favicon($href='favicon.png'){

		$ary = array(
			'rel'=>'icon',
			'type'=>'image/png',
			'href'=>$href
			);

		$this->attributeAry = array_merge($this->attributeAry,$ary);
		$ary = null;

		return $this->linkElement();
	}

	// build a LINK element
	//
	public function linkElement(){

		$this->attributeAry['element'] = 'link';
		$this->attributeAry['close'] = false;

		return $this->htmlElement(true);
	}

	// build External Style Sheet element
	//
	function cssElement($href=null){

		$ary = array(
			'rel'=>'stylesheet',
			'type'=>'text/css',
			'href'=>$href
			);

		$this->attributeAry = array_merge($this->attributeAry,$ary);
		$ary = null;

		$this->cssAry[] = $this->linkElement();
	}

	// build External Javascript element 
	//
	function javascriptElement($href=null){

		$this->attributeAry = array(
			'type'=>'text/javascript',
			'src'=>$href
			);
		$this->jsAry[] = $this->script();
	}

	// build a SCRIPT element
	//
	protected function script(){

		$this->attributeAry['element'] = 'script';

		return $this->htmlElement(true);
	}

	// build a BODY element
	//
	function body(){

		$this->attributeAry['element'] = 'body';
		$this->attributeAry['close'] = false;

		return $this->htmlElement(true);
	}

	// build a new window/tab link
	//
	function newWindow($href,$str){

		$this->attributeAry['onclick'] = "window.open(this.href,'popup'); return false;";

		$this->attributeAry['href'] = $href; 

		$this->attributeAry['dataStr'] = $str;

		$this->attributeAry['element'] = 'a';

		return $this->htmlElement(true,true);
	}

	// build a mailto link
	//
	function mailTo($href,$str){

		$this->attributeAry['href'] = join(array('mailto:',
			$href
			));

		$this->attributeAry['encode'] = true;
		$this->attributeAry['dataStr'] = $str;

		return $this->buildAnchor();
	}

	// build a classic anchor link 
	//
	function hrefLink($href,$str,$id=null){

		$this->attributeAry['id'] = $id;

		$this->attributeAry['href'] = $href;

		$this->attributeAry['dataStr'] = $str;

		return $this->buildAnchor();
	}

	// build a classic anchor link 
	//
	function anchorLink($name,$str,$pre=null,$id=null){

		$this->attributeAry['id'] = $id;

		if($pre !== null){
			$this->attributeAry['href'] = join(array($pre,'#',$name));
		}
		else{

			$this->attributeAry['href'] = join(array('#',$name));
		}

		$this->attributeAry['dataStr'] = $str;

		return $this->buildAnchor();
	}

	// build a classic anchor 
	// not a href link anchor
	//
	function anchor($name){

		$this->attributeAry = array(
			'name'=>$name
			);

		return $this->buildAnchor();
	}

	// build a A element
	//
	protected function buildAnchor(){

		$this->attributeAry['element'] = 'a';

		return $this->htmlElement(true);
	}

	// dep
	//
	function buildHeader($num=1){

		$this->attributeAry['element'] = join(array('h',$num));

		return $this->htmlElement(true);
	}

	// build a parent DIV element
	//
	function parentDiv($o=false){

		$ary = array(
			'element' => 'div',
			'class' => 'parentDiv',
			'close' => false
			);
		$this->load($ary);

		return $this->htmlElement($o);
	}

	function image($src,$alt='Require alt info missing'){

		$ary = array('src' => $src, 
			'alt' => $alt, 
			'title' => $alt, 
			'element' => 'img',
			'close' => false
			); 

		$this->attributeAry = array_merge($this->attributeAry,$ary);

		return $this->htmlElement(true);
	}

	protected function buildSingleAttributes(){

		if(empty($this->singleAttributeAry)){ return false; }

		$this->singleAttributeAry[0] = join(array(' ',$this->singleAttributeAry[0]));

		$this->htmlAttributeAry[] = join(' ',$this->singleAttributeAry);

		$this->singleAttributeAry = array();

		return true;
	}

	// build the attributes
	// this likely belongs in a more generic Element class
	//   a parent to HtmlElement or perhaps HtmlString class
	//   gets renamed ElementString since this will work for generic XML
	//
	protected function buildAttributes(){

		array_walk($this->attributeAry,array(&$this,'htmlAttribute'));

		return true;
	}	

	protected function htmlAttribute($item,$key){

		if($item !== null){

			$this->htmlAttributeAry[] = join(array(' ',
				$key,
				'="',
				$item,
				'"'
				));
		}
	}

	// re-examine
	//
	function encodeData(){ 

		if($this->encode === true){

			return $this->encodeStr($this->dataStr);  //, ENT_QUOTES,'UTF-8');
		}
		return $this->dataStr;
	}

	// do a page / body and html close
	//
	function closePage(){

		return join("\n",array(
			'<!-- end page -->',
			$this->close('body'),
			$this->close('html')
			));
	}

	function closeStr(){

		$this->elementAry[] = join(array('</', 
			$this->elementName,
			'>'
			));
	}

	function close($str=null){

		if(is_string($str)){

			$this->close = true;

			$str = join(
			array("\n",
			'</',
			$str,
			'>',
			"\n"
			));

			$this->htmlElementAry[] = $str;

			return $str;
		}

		if($this->close === true){ 

			$this->closeStr(); 
			return null;
		}
		$this->close = true;

		return null;
	}

	// HTML/XML element build
	//
	protected function build($reset=true){

		// start the element
		$this->elementAry = array('<',$this->elementName);

		if($this->newLine === true){

			$this->elementAry = array("\n",'<',$this->elementName);
		}
				
		// all the attributes
		$this->buildAttributes();

		// the weirdo single (no key) attributes
		$this->buildSingleAttributes();

		// this could be a method depending on html/xml standards weirdo bs
		$this->elementAry[] = '>';

		// encode the actual data if needed
		// there could be a decision method here for weirdo bs
		$this->elementAry[] = $this->encodeData();

		// close the element
		// again could be decision method here for different ways to close
		$this->close();

		// could be more decision making here / validation
		$str = join($this->elementAry);

		if($reset === true){
			$this->resetBuild();
		}
		
		return $str; 
	}

	private function resetBuild(){

		$this->resetAttributes();
		$this->elementAry = array();
		$this->close = true;
		$this->dataStr = null;
		$this->encode = false;
	}

	protected function beginElement($str){

		// start the element
		$ary = array('<',$str);

		// all the attributes
		$this->buildAttributes();

		$ary[] = join($this->htmlAttributeAry);

		$this->htmlAttributeAry = array();

		// the weirdo single (no key) attributes
		$this->buildSingleAttributes();

		$ary[] = join($this->htmlAttributeAry);

		$this->htmlAttributeAry = array();

		// this could be a method depending on html/xml standards weirdo bs
		$ary[] = '>';
	
		$this->resetAttributes();

		return join($ary);
	}

	protected function endElement(){

		return join(array('</', 
			$this->attributeAry['element'],
			'>',"\n"
			));
	}

	public function htmlElement($output=false,$special=false){

		if(empty($this->attributeAry['element'])){

			return false;
		}

		$ary = array(null,null,"\n");

		if($this->attributeAry['encode'] === true){

			$ary[1] = $this->encodeStr($this->attributeAry['dataStr']);  //, ENT_QUOTES,'UTF-8');
		}
		else{ 
			$ary[1] = $this->attributeAry['dataStr'];
		}

		if($this->attributeAry['close'] === true){

			$ary[2] = $this->endElement();
		}

		$element = $this->attributeAry['element'];
		// add all special attributes here to be 
		// nulled before attribute build 
		//
		$this->attributeAry['encode'] = 
		$this->attributeAry['dataStr'] = 
		$this->attributeAry['close'] = 
			$this->attributeAry['element'] = null;

		$ary[0] = $this->beginElement($element);

		if($special === true){

			return join($ary);
		}

		$this->htmlElementAry[] =
			$str = join($ary);

		if($output === true){

			return $str;
		}

		//return true;
	}
}
?>
