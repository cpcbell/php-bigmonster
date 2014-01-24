<?php

/**
{
"Updated": "08.23.2011",
"Author": "Clay Campbell",
"Type": "Unit Test",
"Object": "JSONHtml",
"Name": "jsonHtml.php",
"Description": "JSONHtml builds HTML from JSON Data"
}
**/


define('LIBDIR','/Library/WebServer/Documents/php-bigmonster/lib/');
include_once(join(array(LIBDIR,'JSONHtml.php')));

$s = microtime();
$unitTest = new \BigMonster\Core\Html\JSONHtml; 

$unitTest->dataObj = '[{"method":"html","parameter":"JSONHTML Unit Test"},
{"method":"close","parameter":"head"},
{"method":"body"},
{"method":"parentDiv"},
{"element":"h1","dataStr":"JSONHtml Class builds HTML from JSON"},
{"element":"p","dataStr":"Here is some text in a P (paragraph) element... \"> try to trip it up","encode":true},
{"method":"close","parameter":"div"},
{"method":"closePage"}
]';

$unitTest->jsonToHtml();

echo join($unitTest->htmlElementAry);

$e = microtime();
$t = $e - $s;
echo $t;



exit;
?>
