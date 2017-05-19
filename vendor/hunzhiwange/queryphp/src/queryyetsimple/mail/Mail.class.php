<?php
/* [$QeePHP] (C)WindsForce TEAM Since 2010.10.04.
   Mail 邮件发送类($$)*/

!defined('Q_PATH') && exit;

class Mail{

	protected $_sServer='';
	protected $_nPort=25;
	protected $_bAuth=true;
	protected $_sAuthUsername='';
	protected $_sAuthPassword='';
	protected $_sEmailFrom='';
	protected $_sEmailTo='';
	protected $_nEmailLimiter=1;
	protected $_sEmailSubject='';
	protected $_sEmailMessage='';
	protected $_bEmailUsername=true;
	protected $_sCharset='UTF-8';
	protected $_sSiteName='QeePHP Mail';
	protected $_bIsHtml=true;
	protected $_sContentType='text/plain';
	protected $_sErrorMessage;
	protected $_bIsError;
	CONST PHP_MAIL='mail';
	CONST SOCKET_SMTP ='socket_smtp';
	CONST PHP_SMTP='php_smtp';
	protected $_sEmailSendType=self::SOCKET_SMTP;

	public function __construct($sServer='',$sAuthUsername='',$sAuthPassword='',$nPort=25,$sEmailSendType=self::SOCKET_SMTP){
		$this->_sServer=$sServer;
		$this->_sAuthUsername=$sAuthUsername;
		$this->_sAuthPassword=$sAuthPassword;
		$this->_nPort=$nPort;
		$this->_sEmailSendType=$sEmailSendType;
	}

	public function send(){
		// 邮件头部分隔符
		$sEmailLimiter=$this->_nEmailLimiter==1?"\r\n":($this->_nEmailLimiter==2?"\r":"\n");

		// 邮件SMTP 用户名
		$bEmailUsername=isset($this->_bEmailUsername)?$this->_bEmailUsername:true;

		// 邮件主题
		$sEmailSubject='=?'.$this->_sCharset.'?B?'.base64_encode(str_replace("\r",'',str_replace("\n",'','['.$this->_sSiteName.'] '.$this->_sEmailSubject))).'?=';

		// 邮件内容
		$sEmailMessage=chunk_split(base64_encode(str_replace("\r\n."," \r\n..",str_replace("\n","\r\n",str_replace("\r","\n",str_replace("\r\n","\n",str_replace("\n\r","\r",$this->_sEmailMessage)))))));

		// 邮件发送人
		$arrFrom=array();
		$sEmailFrom=(preg_match('/^(.+?) \<(.+?)\>$/',$this->_sEmailFrom,$arrFrom)?'=?'.$this->_sCharset.'?B?'.base64_encode($arrFrom[1])."?= <$arrFrom[2]>":$this->_sEmailFrom);

		// 邮件接收人
		$arrEmailTo=explode(',',$this->_sEmailTo);
		$arrToUsers=array();
		foreach($arrEmailTo as $sToUser){
			$arrTo=array();
			$arrToUsers[]=preg_match('/^(.+?) \<(.+?)\>$/',$sToUser,$sTo)?($this->_bEmailUsername?'=?'.$this->_sCharset.'?B?'.base64_encode($arrTo[1])."?= <$arrTo[2]>":$arrTo[2]):$sToUser;
		}

		$sEmailTo=implode(',',$arrToUsers);

		// 是否允许HTML 代码
		if($this->_bIsHtml===true){
			$this->_sContentType='text/html';
		}

		// 邮件头部
		$sHeaders="From:{$sEmailFrom}{$sEmailLimiter}X-Priority: 3{$sEmailLimiter}X-Mailer: QeePHP!{$sEmailLimiter}MIME-Version: 1.0{$sEmailLimiter}Content-type: $this->_sContentType; charset={$this->_sCharset}{$sEmailLimiter}Content-Transfer-Encoding: base64{$sEmailLimiter}";
		
		$this->_nPort=$this->_nPort?$this->_nPort:25;// 端口
		if(strtolower($this->_sEmailSendType)==self::PHP_MAIL && function_exists('mail')){
			@mail($sEmailTo,$sEmailSubject,$sEmailMessage,$sHeaders);
		}else if(strtolower($this->_sEmailSendType)==self::PHP_SMTP){
			ini_set('SMTP',$this->_sServer);
			ini_set('smtp_port',$this->_nPort);
			ini_set('sendmail_from',$sEmailFrom);
			@mail($sEmailTo,$sEmailSubject,$sEmailMessage,$sHeaders);
		}else if(strtolower($this->_sEmailSendType)==self::SOCKET_SMTP){
			$nErrNo=0;// 发送
			$nErrStr='';
			if(!($hFp=fsockopen($this->_sServer,$this->_nPort,$nErrNo,$nErrStr,30))){
				$this->setErrorMessage(sprintf("%s:%d CONNECT - can not connect to the SMTP server",$this->_sServer,$this->_nPort));
				return false;
			}
			stream_set_blocking($hFp,true);
			$sLastMessage=fgets($hFp,512);

			if(substr($sLastMessage,0,3)!='220'){
				$this->setErrorMessage(sprintf("%s:%d CONNECT - %s",$this->_sServer,$this->_nPort,$sLastMessage));
				return false;
			}

			fputs($hFp,($this->_bAuth?'EHLO':'HELO')." QeePHP\r\n");
			$sLastMessage=fgets($hFp,512);
			if(substr($sLastMessage,0,3)!=220 && substr($sLastMessage,0,3)!=250){
				$this->setErrorMessage(sprintf("%s:%d HELO/EHLO - %s",$this->_sServer,$this->_nPort,$sLastMessage));
				return false;
			}

			while(1){
				if(substr($sLastMessage,3,1)!='-' || empty($sLastMessage)){
					break;
				}
				$sLastMessage=fgets($hFp,512);
			}

			if($this->_bAuth){
				fputs($hFp,"AUTH LOGIN\r\n");
				$sLastMessage=fgets($hFp,512);
				if(substr($sLastMessage,0,3)!=334){
					$this->setErrorMessage(sprintf("%s:%d AUTH LOGIN - %s",$this->_sServer,$this->_nPort,$sLastMessage));
					return false;
				}

				fputs($hFp,base64_encode($this->_sAuthUsername)."\r\n");
				$sLastMessage=fgets($hFp,512);
				if(substr($sLastMessage,0,3)!=334){
					$this->setErrorMessage(sprintf("%s:%d USERNAME - %s",$this->_sServer,$this->_nPort,$sLastMessage));
					return false;
				}

				fputs($hFp,base64_encode($this->_sAuthPassword)."\r\n");
				$sLastMessage=fgets($hFp,512);
				if(substr($sLastMessage,0,3)!=235){
					$this->setErrorMessage(sprintf("%s:%d PASSWORD - %s",$this->_sServer,$this->_nPort,$sLastMessage));
					return false;
				}
			}

			fputs($hFp,"MAIL FROM: <".preg_replace_callback("/.*\<(.+?)\>.*/",function($arrMatches){ return $arrMatches[1]; },$this->_sEmailFrom).">\r\n");
			$sLastMessage=fgets($hFp,512);

			if(substr($sLastMessage,0,3)!=250){
				fputs($hFp,"MAIL FROM: <".preg_replace_callback("/.*\<(.+?)\>.*/",function($arrMatches){ return $arrMatches[1]; },$this->_sEmailFrom).">\r\n");
				$sLastMessage=fgets($hFp,512);
				if(substr($sLastMessage,0,3)!=250){
					$this->setErrorMessage(sprintf("%s:%d MAIL FROM - %s",$this->_sServer,$this->_nPort,$sLastMessage));
					return false;
				}
			}

			$arrEmailTo=explode(',',$sEmailTo);
			foreach($arrEmailTo as $sToUser){
				$sToUser=trim($sToUser);
				if($sToUser){
					fputs($hFp,"RCPT TO: <".preg_replace_callback("/.*\<(.+?)\>.*/",function($arrMatches){ return $arrMatches[1]; },$sToUser).">\r\n");
					$sLastMessage=fgets($hFp,512);
					if(substr($sLastMessage,0,3)!=250){
						fputs($hFp,"RCPT TO: <".preg_replace_callback("/.*\<(.+?)\>.*/",function($arrMatches){ return $arrMatches[1]; },$sToUser).">\r\n");
						$sLastMessage=fgets($hFp,512);
						$this->setErrorMessage(sprintf("%s:%d RCPT TO - %s",$this->_sServer,$this->_nPort,$sLastMessage));
						return false;
					}
				}
			}

			fputs($hFp,"DATA\r\n");
			$sLastMessage=fgets($hFp,512);

			if(substr($sLastMessage,0,3)!=354){
				$this->setErrorMessage(sprintf("%s:%d DATA - %s",$this->_sServer,$this->_nPort,$sLastMessage));
				return false;
			}

			$sHeaders.='Message-ID: <'.gmdate('YmdHs').'.'.substr(md5($sEmailMessage.microtime()),0,6).rand(100000,999999).'@'.$_SERVER['HTTP_HOST'].">{$sEmailLimiter}";
			fputs($hFp,"Date: ".gmdate('r')."\r\n");
			fputs($hFp,"To:{$sEmailTo}\r\n");
			fputs($hFp,"Subject:{$sEmailSubject}\r\n");
			fputs($hFp,$sHeaders."\r\n");
			fputs($hFp,"\r\n\r\n");
			fputs($hFp,"{$sEmailMessage}\r\n.\r\n");
			$sLastMessage=fgets($hFp,512);

			if(substr($sLastMessage,0,3)!=250){
				$this->setErrorMessage(sprintf("%s:%d DATA - %s",$this->_sServer,$this->_nPort,$sLastMessage));
				return false;
			}

			fputs($hFp,"QUIT\r\n");
		}else{
			$this->setErrorMessage("The wrong way to send e-mail");
			return false;
		}

		return true;
	}

	public function setServer($sServer=''){
		if(empty($sServer)){
			return;
		}

		$sOldValue=$this->_sServer;
		$this->_sServer=$sServer;
		return $sOldValue;
	}

	public function setPort($nPort=25){
		if(empty($nPort)){
			return;
		}
		$nOldValue=$this->_nPort;
		$this->_nPort=$nPort;
		return $nOldValue;
	}

	public function setAuth($bAuth=true){
		$bOldValue=$this->_bAuth;
		$this->_bAuth=$bAuth;
		return $bOldValue;
	}

	public function setAuthUsername($sAuthUsername=''){
		$sOldValue=$this->_sAuthUsername;
		$this->_sAuthUsername=$sAuthUsername;
		return $sOldValue;
	}

	public function setAuthPassword($sAuthPassword=''){
		$sOldValue=$this->_sAuthPassword;
		$this->_sAuthPassword=$sAuthPassword;
		return $sOldValue;
	}

	public function setEmailFrom($sEmailFrom=''){
		$sOldValue=$this->_sEmailFrom;
		$this->_sEmailFrom=$sEmailFrom;
		return $sOldValue;
	}

	public function setEmailTo($sEmailTo=''){
		$sOldValue=$this->_sEmailTo;
		$this->_sEmailTo=$sEmailTo;
		return $sOldValue;
	}

	public function setEmailLimiter($nEmailLimiter=1){
		if(!in_array($nEmailLimiter,array(1,2,3))){
			return;
		}

		$nOldValue=$this->_nEmailLimiter;
		$this->_nEmailLimiter=$nEmailLimiter;
		return $nOldValue;
	}

	public function setEmailSubject($sEmailSubject=''){
		$sOldValue=$this->_sEmailSubject;
		$this->_sEmailSubject=$sEmailSubject;
		return $sOldValue;
	}

	public function setEmailMessage($sEmailMessage=''){
		$sOldValue=$this->_sEmailMessage;
		$this->_sEmailMessage=$sEmailMessage;
		return $sOldValue;
	}

	public function setEmailUsername($bEmailUsername=true){
		$bOldValue=$this->_bEmailUsername;
		$this->_bEmailUsername=$bEmailUsername;
		return $bOldValue;
	}

	public function setCharset($sCharset='UTF-8'){
		$sOldValue=$this->_sCharset;
		$this->_sCharset=$sCharset;
		return $sOldValue;
	}

	public function setSiteName($sSiteName=''){
		$sOldValue=$this->_sSiteName;
		$this->_sSiteName=$sSiteName;
		return $sOldValue;
	}

	public function setIsHtml($bIsHtml=true){
		$bOldValue=$this->_bIsHtml;
		$this->_bIsHtml=$bIsHtml;
		return $bOldValue;
	}

	public function setContentType($sContentType='text/plain'){
		$sOldValue=$this->_sContentType;
		$this->_sContentType=$sContentType;
		return $sOldValue;
	}

	public function getServer(){
		return $this->_sServer;
	}

	public function getPort(){
		return $this->_nPort;
	}

	public function getAuth(){
		return $this->_bAuth;
	}

	public function getAuthUsername(){
		return $this->_sAuthUsername;
	}

	public function getAuthPassword(){
		return $this->_sAuthPassword;
	}

	public function getEmailFrom(){
		return $this->_sEmailFrom;
	}

	public function getEmailTo(){
		return $this->_sEmailTo;
	}

	public function getEmailLimiter(){
		return $this->_nEmailLimiter;
	}

	public function getEmailSubject(){
		return $this->_sEmailSubject;
	}

	public function getEmailMessage(){
		return $this->_sEmailMessage;
	}

	public function getEmailUsername(){
		return $this->_bEmailUsername;
	}

	public function getCharset(){
		return $this->_sCharset;
	}

	public function getSiteName(){
		return $this->_sSiteName;
	}

	public function getIsHtml(){
		return $this->_bIsHtml;
	}

	public function getContentType(){
		return $this->_sContentType;
	}

	protected function setIsError($bIsError=false){
		$bOldValue=$this->_bIsError;
		$this->_bIsError=$bIsError;
		return $bOldValue;
	}

	protected function setErrorMessage($sErrorMessage=''){
		$this->setIsError(true);
		$sOldValue=$this->_sErrorMessage;
		$this->_sErrorMessage=$sErrorMessage;
		return $sOldValue;
	}

	public function isError(){
		return $this->_bIsError;
	}

	public  function getErrorMessage(){
		return $this->_sErrorMessage;
	}

}
