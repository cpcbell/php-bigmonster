<?php

/**
{
"Updated": "01.21.2014",
"Author": "Clay Campbell",
"Type": "Unit Test",
"Object": "StringClass",
"Name": "stringClass.php",
"Description": "Very basic, generic string building object."
}
**/

define('LIBDIR','/Library/WebServer/Documents/php-bigmonster/lib/');

include_once(join(array(LIBDIR,'StringClass.php')));

$unitTest = new \BigMonster\Core\StringClass; 

echo 'Unit Test for StringClass.php';

echo '<br><br>';
echo 'Test a string value with isString() method TEST:';
$unitTest->str = 'ConstantLoader';
echo ($unitTest->isString() === true) ? ' Pass' : ' Fail';

echo '<br><br>';
echo 'cast() method TEST:';
$unitTest->str = 0; 
$unitTest->cast();
echo (is_string($unitTest->str)) ? ' Pass' : ' Fail';

echo '<br><br>';
echo 'aryToStr() method ary elements seperated by whitespace TEST:';
$unitTest->ary = array('After','these','messages','we','will','be','right','back');
$unitTest->joinStr = ' ';
echo '<br><br>';
print_r($unitTest->ary);
echo '<br><br>';
echo $unitTest->aryToStr();

echo '<br><br>';
echo 'callbackAryToStr() method ary elements modifed to upper-case using toUpper() still seperated by whitespace TEST:';
$unitTest->callbackMethod = 'toUpper';
echo '<br><br>';
echo $unitTest->callbackAryToStr();

echo '<br><br>';
echo 'Return a random string of letters:';
$unitTest->randomLetterString();
echo '<br><br>';
echo $unitTest->finalStr;

echo '<br><br>';
echo 'Base64 encode and decode the random string of letters:';
$unitTest->str = $unitTest->finalStr;
$unitTest->base64Encode();
echo '<br><br>';
echo $unitTest->finalStr;

$unitTest->str = $unitTest->finalStr;
$unitTest->base64Decode();
echo '<br><br>';
echo $unitTest->finalStr;

exit;
