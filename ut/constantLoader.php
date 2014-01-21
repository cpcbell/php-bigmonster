<?php

/**
{
"Updated": "09.30.2010",
"Author": "Clay Campbell",
"Type": "Unit Test",
"Object": "ConstantLoader",
"Parent": "FileDevice",
"Name": "constantLoader.php",
"Description": "Loads and sets constants from a text file."
}
**/

define('LIBDIR','/Library/WebServer/Documents/php-bigmonster/lib/');
include_once(join(array(LIBDIR,'ConstantLoader.php')));

$unitTest = new \BigMonster\Core\ConstantLoader; 

define('CPATH','/Library/WebServer/Documents/php-bigmonster/ut/');

echo '<br>This unit test is for ConstantLoader.<br><br>
Constants are supplied in a text file in this format: <br><br>
DEBUG:1<br>
MYCONSTANT:some_value<br>
<br><br>
Does the default config directory (current unit test directory) exist and is it readable / contains files'; 
echo '<br>';

if($unitTest->checkConfDir()){

	echo 'Config directory exists and appears readable.'; 
	echo '<br>';
	var_dump($unitTest->dirAry);

	echo '<br><br>';
	echo 'Setting the config constant file to defaults.conf';
	echo '<br><br>';

	if($unitTest->setConfigFile('defaults.conf')){

		echo 'defaults.conf constant config set and is readable';

		echo '<br><br>';
		echo 'Define and load the constants found in defaults.conf';
		echo '<br><br>';
		$unitTest->loadConstants();
		echo '<br><br>';
		var_dump($unitTest->constantAry);
		echo '<br><br>';
	}
	else{
		echo 'config file was not readable';
	}
}
else{

	echo 'Config directory does NOT exist or is empty.';
}

echo 'Does the DEBUG constant exist and is it set? ( should echo 1 )';
echo '<br><br>';

if(defined('DEBUG')){
    echo 'Yep!<br>';
	echo DEBUG;
	echo '<br><br>';
}
else{
    echo 'Was not able to find the constant as expected!<br><br>';
}

echo 'Does the MYCONSTANT constant exist and is it set? ( should echo some_value )';
echo '<br><br>';

if(defined('MYCONSTANT')){
    echo 'Yep!<br>';
	echo MYCONSTANT;
	echo '<br><br>';
}
else{
    echo 'Was not able to find the constant as expected!<br><br>';
}

?>
