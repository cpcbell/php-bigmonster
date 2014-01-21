<?php
namespace BigMonster\Core;

/**
{
"Updated": "04.13.2012",
"Author": "Clay Campbell",
"Type": "Object",
"Object": "FileDevice",
"Parent": "N/A",
"Name": "FileDevice",
"Description": "Class (should be an Interface?) wrapper for PHP5 File/FileSystem related methods",
}
**/

class FileDevice{

	private $fH; 

	protected $mode; 

	function __construct(){

		$this->name =
		$this->dir =
		$this->readFrom =
		$this->writeTo =
		$this->buffer = NULL;

		$this->bytes = 2048;

		$this->filterAry =
		$this->dirAry = 
			$this->fileStatAry = array();
	}

	public function isDir(){

		return is_dir($this->dir);
	}

	public function exists(){

		return is_file($this->name);
	}

	public function readable(){

		return is_readable($this->name);
	}

	public function writable(){

		return is_writable($this->name);
	}

	public function write(){

		$this->mode = 'w';
		$this->writeFile();
	}

	public function append(){

		$this->mode = 'a';
		$this->writeFile();
	}

	public function read(){

		$this->mode = 'r';
		return $this->readFile();

	}

	public function readURL(){

		$this->mode = 'rb';
		return $this->readFile();
	}

	/*
	Return last modified timestamp
	*/
	public function mTime(){

		if($this->fileStatAry[9]){
	
			return $this->fileStatAry[9];
		}
		return FALSE;
	}	

	public function size(){

		if($this->fileStatAry[7]){

                        return $this->fileStatAry[7];
                }
                return FALSE;
	}

	// creates an array of contents of a directory
	//
	public function dirList(){

		$d = dir($this->dir);

		while (FALSE !== ($entry = $d->read())) {

			if($entry === '.' || $entry === '..'){ continue; }

			/* this would hide protected files from bigmonster
			 might be useful later
			 if($this->nameFilter()){		
			 }
			*/
			array_push($this->dirAry,$entry);
		}

		$d->close();

		if(empty($this->dirAry)){

			return FALSE;
		}

		return TRUE;
	}

	protected function openHandle(){

		$this->checkName();

		$this->fH = @fopen($this->name,$this->mode);

		if($this->fH === FALSE){ return FALSE; }

		$this->statFile();
		return TRUE;

	}

	protected function statFile(){

		clearstatcache();
		$this->fileStatAry = fstat($this->fH);
	}

	// needs better return handling 
	//
	protected function writeFile(){

		$this->checkName();
		
		$this->fH = @fopen($this->name,$this->mode);

		if($this->fH){
			
			fwrite($this->fH, $this->buffer);
			
		}
		else{
			//error opening file handle
		}

		@fclose($this->fH);
	}

	protected function readFile(){

		if($this->openHandle()){

			$ary = array();

			while(!feof($this->fH)){
				$ary[] = fread($this->fH, $this->bytes);
					
			}

			$this->buffer = rtrim(join($ary));

			$ary = NULL;
			// or this 
			// 
			//$this->buffer  fread($this->fH, filesize($this->name));

			fclose($this->fH);

			return TRUE;
		}
		return FALSE;
	}

	// Allows for a filter to restrict file handling 
	// should be expanded to an array of file filters
	//
	protected function checkName(){

		if($this->nameFilter() === TRUE){
		
			die('Illegal File manipulation attempt');

		}
	}

	// this is where it would loop thru the filter ary
	//
	protected function nameFilter(){

		if(empty($this->filterAry)){ return FALSE; } 

		$ct = count($this->filterAry);

		for($a=0;$a<$ct;++$a){

			if(preg_match($this->filterAry[$a],$this->name)){

				return TRUE;
			}
		}

		return FALSE;
	}

	// this will read a stream and write it to a file
	// should be public
	//
	protected function overWrite(){

		$this->name = $this->readFrom;

		if($this->readURL()){

			@fclose($this->fH);

			$this->name = $this->writeTo;	

			if($this->writable()){

				$this->write();

				return TRUE;
			}
		}
		return FALSE;
	}
// class end
}
?>
