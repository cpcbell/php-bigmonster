<?php

/**
{
"Updated": "05.09.2011",
"Author": "Clay Campbell",
"Type": "Unit Test",
"Object": "HtmlString",
"Parent": "StringClass",
"Name": "htmlString.php",
"Description": "Very basic, generic HTML string building object."
}
**/


define('LIBDIR','/Library/WebServer/Documents/php-bigmonster/lib/');
include_once(join(array(LIBDIR,'HtmlString.php')));

$unitTest = new \Bigmonster\Core\Html\HtmlString; 

echo 'Is this string "http://www.google.com" a Url/link?<br>';
echo ($unitTest->isLink('http://www.google.com')) ? 'true' : 'false'; 
echo '<br>';

$str = '<HTML><HEAD><TITLE>head or tail</TITLE></HEAD><BODY>Bob<DIV>Smith</DIV></BODY></HTML>';

echo $unitTest->removeHtml($str);
echo '<br><br>';

echo $unitTest->removeHtmlTags($str);
echo '<br><br>';

exit;
