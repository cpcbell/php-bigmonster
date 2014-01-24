<?php

/**
{
"Updated": "08.22.2011",
"Author": "Clay Campbell",
"Type": "Unit Test",
"Object": "HtmlElement",
"Parent": "HtmlString",
"Name": "htmlElement.php",
"Description": "Very basic string building object for HTML.  Object should be as efficient as possible."
}
**/


define('LIBDIR','/Library/WebServer/Documents/php-bigmonster/lib/');
include_once(join(array(LIBDIR,'HtmlElement.php')));

$s = microtime();
$unitTest = new \Bigmonster\Core\Html\HtmlElement; 

$unitTest->html('Unit Test for class HtmlElement.php');

$unitTest->cssElement('default.css');
$unitTest->contentTypeMeta();
$unitTest->nameMeta('keywords','unit test html element');
$unitTest->close('head');
$unitTest->body();

$unitTest->attributeAry['element'] = 'div';
$unitTest->attributeAry['class'] = 'parentDiv';
$unitTest->attributeAry['close'] = false;
$unitTest->htmlElement();

$unitTest->attributeAry['element'] = 'h1';
$unitTest->attributeAry['dataStr'] = 'Unit Test for class HtmlElement.php';
$unitTest->htmlElement();

$unitTest->comment('A comment');

// the new way
$ary = array('element'=>'div','id' => 'testId0',
'class' => 'testClass',
'style' => 'padding: 6px; border: 1px solid #000000;',
'dataStr' => 'A simple DIV',
'close' => false);
$unitTest->load($ary); 

$unitTest->htmlElement();

$ary = array('element'=>'div','dataStr' => 'A simple DIV inside the first DIV',
'style' => 'padding: 10px; border: 3px solid green;'
);

$unitTest->load($ary);
$unitTest->htmlElement();

$unitTest->close('div');

$unitTest->hrefLink('http://www.google.com','A link to Google');
$unitTest->newWindow('http://www.google.com','A new window link to Google');

$unitTest->close('div');
$unitTest->close('body');
$unitTest->close('html');

echo join($unitTest->htmlElementAry);

$e = microtime();
$t = $e - $s;
echo $t;
exit;
