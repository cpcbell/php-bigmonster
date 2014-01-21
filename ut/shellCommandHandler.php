<?php
/**
{
"Updated": "01.21.2014",
"Author": "Clay Campbell",
"Type": "Unit Test",
"Object": "ShellCommandHandler",
"Name": "shellCommandHandler.php",
"Description": "Run a shell command and store the output"
}
**/

define('LIBDIR','/Library/WebServer/Documents/php-bigmonster/lib/');
include_once(join(array(LIBDIR,'ShellCommandHandler.php')));

$unitTest = new \BigMonster\Core\ShellCommandHandler; 

echo '<html><body>';

echo '<div>Can we run ls -alt in the current directory?</div>';

$unitTest->cmd = 'ls -alt';
$unitTest->workingDir = '.';

if( $unitTest->run() ){

	echo join(array('<div>Yep!</div><div>',nl2br($unitTest->output),'</div>'));
}
else{
    echo '<div>Oops... something went very wrong!';
}

echo '</body></html>';

exit;

?>
