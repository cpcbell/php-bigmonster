<?php

/**
{
"Updated": "01.21.2014",
"Author": "Clay Campbell",
"Type": "Unit Test",
"Object": "FileDevice",
"Name": "fileDevice.php",
"Description": "Basic File Device Object."
}
**/

define('LIBDIR','/Library/WebServer/Documents/php-bigmonster/lib/');
include_once(join(array(LIBDIR,'FileDevice.php')));

$obj = new \BigMonster\Core\FileDevice;

$obj->dir = LIBDIR;

echo '<br>Does this current directory exist?<br>';

if ( $obj->isDir() ){
    echo '<br>Yes of course it does!<br>';
}
else{
    echo '<br>No so something is very wrong!<br>';
}

echo '<br>Does our test file exist (test.txt)?<br>';

$obj->name = 'test.txt';

if ( $obj->exists() ){
    echo '<br>Yes of course it does!<br>';
}
else{
    echo '<br>No so something is very wrong!<br>';
}

echo '<br>Can we list the contents of this directory?<br>';

$obj->dir = join(array($_SERVER['DOCUMENT_ROOT'],'/php-bigmonster/'));

if ( $obj->dirList() ){
    echo '<br>Yep!<br>';
    print_r($obj->dirAry);
}
else{
    echo '<br>No so something is very wrong!<br>';
}

echo '<br><br>Can we get a read file handle for our test file?<br>';

if ( $obj->read() ){
    echo '<br>Yep!<br>';
    
    echo $obj->buffer;
}
else{
    echo '<br>No so something is very wrong!<br>';
}


exit;
