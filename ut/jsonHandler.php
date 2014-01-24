<?php

/**
{
"Updated": "05.10.2011",
"Author": "Clay Campbell",
"Type": "Unit Test",
"Object": "JSONHandler",
"Name": "jsonHandler.php",
"Description": "Encode/Decode JSON data"
}
**/


define('LIBDIR','/Library/WebServer/Documents/php-bigmonster/lib/');
include_once(join(array(LIBDIR,'JSONHandler.php')));

$unitTest = new \BigMonster\Core\JSON\JSONHandler; 

echo '<br>';
echo 'Setting up an array(id=1,name=bob,3,4)';
echo '<br>';
$unitTest->dataObj = array('id'=>1,'name'=>'bob','int0'=>3,'int1'=>4);

$unitTest->encode();
echo '<br>';
echo 'Array was encoded... here is JSON string of the array: ';
echo '<br>';
echo $unitTest->jsonObj;
echo '<br>';

$unitTest->decode();
echo '<br>';

echo 'Dump of the decoded JSON string using decode() method ... notice its an object ';
echo '<br>';
echo var_dump($unitTest->dataObj);
echo '<br>';
echo '<br>';


echo 'Dump of the decoded JSON string using decodeAry() method  ';
echo '<br>';
echo var_dump($unitTest->decodeAry());

?>
