<?php
namespace BigMonster\Core{

/**
{
"Updated": "09.30.2010",
"Author": "Clay Campbell",
"Type": "Object",
"Object": "ConstantLoader",
"Parent": "FileDevice",
"Name": "ConstantLoader",
"Description": "Sets constants from a text file.",
}
**/

include_once(join(array(LIBDIR,'FileDevice.php')));

class ConstantLoader extends FileDevice{

	public $name;

	function __construct(){

		parent::__construct();


		$this->name = 
			$this->dir = NULL;

		$this->constantCt = 0;
		$this->constantAry = array();

		$this->splitPatternStr = '/\n/';
	}

	public function checkConfDir(){

		$this->dir = CPATH;

		if($this->isDir() === TRUE){

			return $this->dirList();	
		}

		return FALSE;
	}

	public function setConfigFile($str){

		$this->name = join(array(CPATH,$str));

		return $this->readable();
	}

	public function loadConstants(){

		return $this->reader();
	}

	protected function reader(){

		if($this->read() === TRUE){

			$ary = preg_split($this->splitPatternStr,$this->buffer);
			$this->constantCt = count($ary);

			for($a=0;$a<$this->constantCt;++$a){

				$this->constantAry[$a] = explode(':',$ary[$a]);

				if(defined($this->constantAry[$a][0]) || 
					empty($this->constantAry[$a][0]) || 
					empty($this->constantAry[$a][1])){
					continue;
				}
					
				if((strcasecmp($this->constantAry[$a][1],'true') == 0) || 
					(strcasecmp($this->constantAry[$a][1],'false') == 0)){

					$this->constantAry[$a][1] = (bool)$this->constantAry[$a][1];
				}

				define($this->constantAry[$a][0],$this->constantAry[$a][1]);
			}
			return TRUE;
		}
		return FALSE;
	}
// class end
}
// NS end
}
?>
