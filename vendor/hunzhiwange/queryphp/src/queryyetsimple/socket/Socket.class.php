<?php
/* [DoYouHaoBaby!] (C)Dianniu From 2010.
   Socket实现类($)*/

!defined('DYHB_PATH') && exit;

class Socket{

	protected $_arrConfig=array(
		'persistent'=>false,
		'host'=>'localhost',
		'protocol'=>'tcp',
		'port'=>80,
		'timeout'=>30
	);
	public $_oConnection=null;
	public $_bConnected=false;
	public $_arrError=array();

	public function __construct($arrConfig=array()){
		$this->_arrConfig=array_merge($this->_arrConfig,$arrConfig);
		if(!is_numeric($this->_arrConfig['protocol'])){
			$this->_arrConfig['protocol']=getprotobyname($this->_arrConfig['protocol']);
		}
	}

	public function connect(){
		if($this->_oConnection!=null){
			$this->disConnect();
		}

		if($this->_arrConfig['host']=='localhost'){
			$this->_arrConfig['host']='127.0.0.1';
		}

		if($this->_arrConfig['persistent']==true){
			$sTmp=null;
			$nErrNum=0;
			$sErrStr='';
			$this->_oConnection=@pfsockopen($this->_arrConfig['host'],(($this->_arrConfig['port'])?$this->_arrConfig['port']:"80"),$nErrNum,$sErrStr,$this->_arrConfig['timeout']);
		}else{
			$this->_oConnection=fsockopen($this->_arrConfig['host'],$this->_arrConfig['port'],$nErrNum,$sErrStr,$this->_arrConfig['timeout']);
		}

		if(!empty($nErrNum) || !empty($sErrStr)){
			$this->error($sErrStr,$nErrNum);
		}

		$this->_bConnected=is_resource($this->_oConnection);

		return $this->_bConnected;
	}

	public function error(){}

	public function write($sData){
		if(!$this->_bConnected){
			if(!$this->connect()){
				return false;
			}
		}

		return fwrite($this->_oConnection,$sData,strlen($sData));
	}

	public function read($nLength=1024){
		if(!$this->_bConnected){
			if(!$this->connect()){
				return false;
			}
		}

		if(!feof($this->_oConnection)){
			return fread($this->_oConnection,$nLength);
		}else{
			return false;
		}
	}

	public function disConnect(){
		if(!is_resource($this->_oConnection)){
			$this->_bConnected=false;
			return true;
		}

		$this->_bConnected=!fclose($this->_oConnection);
		if(!$this->_bConnected){
			$this->_oConnection=null;
		}

		return !$this->_bConnected;
	}

	public function __destruct(){
		$this->disConnect();
	}

}
