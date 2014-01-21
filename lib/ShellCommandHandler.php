<?php
namespace BigMonster\Core;

include_once(join(array(LIBDIR,'FileDevice.php')));
/**
{
"Updated": "01.21.2014",
"Author": "Clay Campbell",
"Type": "Object",
"Object": "ShellCommandHandler",
"Parent": "FileDevice",
"Name": "ShellCommandHandler",
"Description": "Execute shell commands and save output"
}
**/

class ShellCommandHandler extends FileDevice{

        function __construct(){

		parent::__construct();

		$this->pH = 
		$this->outputStatus = FALSE;

		$this->workingDir = 
			$this->envAry = 
			$this->cmd =  
			$this->input = 
			$this->output = 
			$this->status = 
			$this->returnValue = NULL;

		$this->descriptorSpecAry = array(
    			array("pipe","r"),
    			array("pipe","w"),
    			array("pipe","a")
  			); 

		$this->pipesAry = array();
	}

	protected function open(){

		if(empty($this->cmd) || empty($this->workingDir)){ return FALSE; }

		$this->pH = proc_open($this->cmd,
			$this->descriptorSpecAry,
			$this->pipesAry,
			$this->workingDir,
			$this->envAry);	

		if(is_resource($this->pH) == FALSE){

			return FALSE;
		}

		return TRUE;
	}

	protected function input(){

		if(!empty($this->pipesAry[0])){

			$this->name = $this->pipesAry[0];
			$this->buffer = $this->input;

			$this->write();

		}
		/*
		fwrite($this->pipesAry[0], $this->input);
                fclose($this->pipesAry[0]);
		*/
	}

	protected function output(){

		if(empty($this->pipesAry[1])){

			return FALSE;
		}

		$this->output = NULL;

		$this->output = stream_get_contents($this->pipesAry[1]);

		if(empty($this->output)){ return FALSE; }

		return TRUE;
	}

	function status(){

		$this->status = proc_get_status($this->pH);
	}

	public function run(){

		if($this->open() == TRUE){

                        $this->input();

                        $this->outputStatus = $this->output();

			$this->close();

			return TRUE;
		}

		return FALSE;
        }

	function close(){

		$this->returnValue = proc_close($this->pH);

		return TRUE;
	}
// class end
}

?>
