<?php
/* [$QeePHP] (C)WindsForce TEAM Since 2010.10.04.
   文件上传($$)*/

!defined('Q_PATH') && exit;

class UploadFile{

	const UPLOAD_ERR_OK=0;// 文件成功上传
	const UPLOAD_ERR_INI_SIZE=1;// 其值为 1，上传的文件超过了 php.ini 中 upload_max_filesize 选项限制的值
	const UPLOAD_ERR_FORM_SIZE=2;// 其值为 2，上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值
	const UPLOAD_ERR_PARTIAL=3; // 其值为 3，文件只有部分被上传
	const UPLOAD_ERR_NO_FILE=4;// 文件未上传
	const UPLOAD_ERR_NO_TMP_DIR=6; // 其值为 6，找不到临时文件夹
	const UPLOAD_ERR_CANT_WRITE=7;// 文件写入失败
	static public $MAXSIZE=204800;
	public $_nMaxSize=-1;
	public $_bSupportMulti=true;
	public $_arrAllowExts=array();
	public $_arrNotAllowExts=array('php','php5');
	public $_arrAllowTypes=array();
	public $_arrNotAllowTypes=array();
	public $_bThumb=false;
	public $_nThumbMaxWidth;
	public $_nThumbMaxHeight;
	public $_sThumbPrefix='thumb_';
	public $_sThumbSuffix='';
	public $_sThumbPath='';
	public $_sThumbFile='';
	public $_bThumbRemoveOrigin=false;
	public $_bThumbFixed=false;
	public $_bAutoSub=false;
	public $_sSubType='hash';
	public $_sDateFormat='Ymd';
	public $_nHashLevel= 1; // hash的目录层次
	public $_sSavePath='';
	public $_bAutoCheck=true; // 是否自动检查附件
	public $_bUploadReplace=false;
	public $_sSaveRule='';
	public $_sHashType='md5_file';
	protected $_sError='';
	protected $_arrUploadFileInfo;
	protected $_bKeepOriginalName=false;
	protected $_bAutoCreateStoreDir=false;
	protected $_sLastInput;
	protected $_arrLastFileinfo=array();
	protected $_bWriteSafeFile=true;
	public $_bIsImagesWaterMark=false;
	const TEXT='text';
	const IMG='img';
	public $_sImagesWaterMarkType=self::TEXT;
	public $_arrImagesWaterMarkImg=array(
		'path'=>'',
		'offset'=>''
	);
	public $_arrImagesWaterMarkText=array(
		'content'=>'QeePHP',
		'textColor'=>'#000000',
		'textFont'=>'',
		'textFile'=>'',
		'offset'=>''
	);
	public $_nWaterPos=0;

	public function __construct($nMaxSize='',$AllowExts='',$AllowTypes='',$sSavePath='',$sSaveRule=''){
		if(!empty($nMaxSize)&& is_numeric($nMaxSize)){
			$this->_nMaxSize=$nMaxSize;
		}

		if(!empty($AllowExts)){
			if(is_array($AllowExts)){
				$this->_arrAllowExts=array_map('strtolower',$AllowExts);
			}else{
				$this->_arrAllowExts=explode(',',strtolower($AllowExts));
			}
		}

		if(!empty($AllowTypes)){
			if(is_array($AllowTypes)){
				$this->_arrAllowTypes=array_map('strtolower',$AllowTypes);
			}else{
				$this->_arrAllowTypes=explode(',',strtolower($AllowTypes));
			}
		}

		if(!empty($sSaveRule)){
			$this->_sSaveRule=$sSaveRule;
		}else{
			$this->_sSaveRule=$GLOBALS['_commonConfig_']['UPLOAD_FILE_RULE'];
		}

		$this->_sSavePath=$sSavePath;
	}

	protected function save($arrFile){
		$sFilename=$arrFile['savepath'].'/'.$arrFile['savename'];

		if(!$this->_bUploadReplace && is_file($sFilename)){// 不覆盖同名文件
			$this->_sError=Q::L('文件%s已经存在！','__QEEPHP__@Q',null,$sFilename);
			return false;
		}

		if(in_array(strtolower($arrFile['extension']),array('gif','jpg','jpeg','bmp','png','swf')) && false=== getimagesize($arrFile['tmp_name'])){// 如果是图像文件 检测文件格式
			$this->_sError=Q::L('非法图像文件','__QEEPHP__@Q');
			return false;
		}

		if($this->_bIsImagesWaterMark && in_array(strtolower($arrFile['extension']),array('jpg','jpeg'))){// 创建水印
			$this->imageWaterMark($arrFile['tmp_name']);
		}

		if(!is_dir(dirname($sFilename)) && !C::makeDir(dirname($sFilename))){// 如果文件名为xx/yy/zz，则还需要创建目录，否则无法移动
			$this->_sError=Q::L('上传目录%s不可写','__QEEPHP__@Q',null,dirname($sFilename));
			return false;
		}

		if(!move_uploaded_file($arrFile['tmp_name'],C::gbkToUtf8($sFilename,'utf-8','gb2312'))){
			$this->_sError=Q::L('文件上传保存错误','__QEEPHP__@Q');
			return false;
		}

		if($this->_bThumb && in_array(strtolower($arrFile['extension']),array('gif','jpg','jpeg','bmp','png'))){
			$arrImage=getimagesize($sFilename);
			if(false!==$arrImage){//是图像文件生成缩略图
				$arrThumbWidth=explode(',',$this->_nThumbMaxWidth);
				$arrThumbHeight=explode(',',$this->_nThumbMaxHeight);
				$arrThumbPrefix=explode(',',$this->_sThumbPrefix);
				$arrThumbSuffix=explode(',',$this->_sThumbSuffix);
				$arrThumbFile=explode(',',$this->_sThumbFile);
				$sThumbPath=$this->_sThumbPath?$this->_sThumbPath:dirname($arrFile['savepath']);

				// 检查缩略图目录
				if(!is_dir($sThumbPath)){
					// 检查目录是否编码后的
					if(is_dir(base64_decode($sThumbPath))){
						$sThumbPath=base64_decode($sThumbPath);
					}else{// 尝试创建目录
						if(!$this->_bAutoCreateStoreDir){
							$this->_sError(Q::L("存储目录不存在：“%s”",'__QEEPHP__@Q',null,$sThumbPath));
							return false;
						}else if(!mkdir($sThumbPath)){
							$this->_sError=Q::L('上传目录%s不可写','__QEEPHP__@Q',null,$sThumbPath);
							return false;
						}
					}

					// 写入目录安全文件
					if($this->_bWriteSafeFile){
						$this->writeSafeFile($sThumbPath);
					}
				}

				// 生成图像缩略图
				$sRealFilename=$this->_bAutoSub?$arrFile['savename']:$arrFile['savename'];
				$sRealFilename=strripos($sRealFilename,'.')?C::subString($sRealFilename,0,strrpos($sRealFilename,'.')):$sRealFilename;

				for($nI=0,$nLen=count($arrThumbWidth);$nI<$nLen;$nI++){
					$sThumbname=$sThumbPath.'/'.(isset($arrThumbPrefix[$nI])?$arrThumbPrefix[$nI]:$arrThumbPrefix[0]).$sRealFilename.(isset($arrThumbSuffix[$nI])?$arrThumbSuffix[$nI]:$arrThumbSuffix[0]).'.'.$arrFile['extension'];
					if($this->_bThumbFixed===true){
						Image::thumb($sFilename,$sThumbname,'',(isset($arrThumbWidth[$nI])?$arrThumbWidth[$nI]:$arrThumbWidth[0]),(isset($arrThumbHeight[$nI])?$arrThumbHeight[$nI]:$arrThumbHeight[0]),true,true);
					}else{
						Image::thumb($sFilename,$sThumbname,'',(isset($arrThumbWidth[$nI])?$arrThumbWidth[$nI]:$arrThumbWidth[0]),(isset($arrThumbHeight[$nI])?$arrThumbHeight[$nI]:$arrThumbHeight[0]),true);
					}
				}

				// 生成缩略图之后删除原图
				if($this->_bThumbRemoveOrigin){
					@unlink($sFilename);
				}
			}
		}

		return true;
	}

	protected function imageWaterMark($sFilename){
		if($this->_sImagesWaterMarkType==self::IMG && !empty($this->_arrImagesWaterMarkImg['path'])){// 图片水印
			$arrWaterArgs=&$this->_arrImagesWaterMarkImg;
			$arrWaterArgs['type']=self::IMG;
			$bResult=Image::imageWaterMark($sFilename,$this->_nWaterPos,$arrWaterArgs,false);
			if($bResult!==true){
				E($bResult);
				return false;
			}
		}elseif($this->_sImagesWaterMarkType==self::TEXT){// 文字水印
			$arrWaterArgs=&$this->_arrImagesWaterMarkText;
			$arrWaterArgs['type']=self::TEXT;
			$bResult=Image::imageWaterMark($sFilename,$this->_nWaterPos,$arrWaterArgs,false);
			if($bResult!==true){
				E($bResult);
				return false;
			}
		}
	}

	public function upload($sSavePath=''){
		// 如果不指定保存文件名，则由系统默认
		if(empty($sSavePath)){
			$sSavePath=$this->_sSavePath;
		}

		// 检查上传目录
		if(!is_dir($sSavePath)){
			if(is_dir(base64_decode($sSavePath))){
				$sSavePath=base64_decode($sSavePath);
			}else{// 尝试创建目录
				if(!$this->_bAutoCreateStoreDir){
					$this->_sError(Q::L("存储目录不存在：“%s”",'__QEEPHP__@Q',null,$sSavePath));
					return false;
				}else if(!C::makeDir($sSavePath)){
					$this->_sError=Q::L('上传目录%s不可写','__QEEPHP__@Q',null,$sSavePath);
					return false;
				}
			}
		}else{
			if(!is_writeable($sSavePath)){
				$this->_sError=Q::L('上传目录%s不可写','__QEEPHP__@Q',null,$sSavePath);
				return false;
			}
		}

		if($this->_bWriteSafeFile){
			$this->writeSafeFile($sSavePath);// 写入目录安全文件
		}

		$arrFileInfo=array();
		$bIsUpload=false;
		$arrFiles=$this->dealFiles($_FILES);// 获取上传的文件信息&对$_FILES数组信息处理
		foreach($arrFiles as $nKey=>$arrFile){
			if(!empty($arrFile['name'])){// 过滤无效的上传
				$this->_sLastInput=$arrFile['name'];
				$arrFile['key']=$nKey;
				$arrFile['extension']=strtolower($this->getExt($arrFile['name']));// 登记上传文件的扩展信息
				$arrFile['savepath']=$sSavePath;
				$arrFile['savename']=$this->getSaveName($arrFile);
				$arrFile['isthumb']=$this->_bThumb && in_array($arrFile['extension'],array('gif','jpg','jpeg','bmp','png'))?1:0;
				$arrFile['thumbprefix']=$this->_sThumbPrefix;
				$arrFile['thumbpath']=$this->_sThumbPath;
				$arrFile['module']=MODULE_NAME;

				if($this->_bAutoCheck){// 自动检查附件
					if(!$this->check($arrFile)){
						return false;
					}
				}

				if(!$this->save($arrFile)){
					return false;
				}

				if(function_exists($this->_sHashType) && is_file($arrFile['savepath'].'/'.$arrFile['savename'])){
					$sFun= $this->_sHashType;
					$arrFile['hash']=$sFun(C::gbkToUtf8($arrFile['savepath'].'/'.$arrFile['savename'],'utf-8','gb2312'));
				}else{
					$arrFile['hash']='';
				}

				unset($arrFile['tmp_name'],$arrFile['error']);// 上传成功后保存文件信息，供其他地方调用
				$this->_arrLastFileinfo=$arrFile;
				$arrFileInfo[]=$arrFile;

				$bIsUpload=true;
			}
		}

		if($bIsUpload){
			$this->_arrUploadFileInfo=$arrFileInfo;
			return true;
		}else{
			$this->error(self::UPLOAD_ERR_PARTIAL);
			return false;
		}
	}

	public function getSavePath($sInputName=null){
		return $this->_arrLastFileinfo[($sInputName==null)?$this->_sLastInput:$sInputName];
	}

	protected function dealFiles($arrFiles){
		$arrFileInfo=array();

		if(is_array($arrFiles)){
			foreach($arrFiles as $arrFile){
				if(is_array($arrFile['name'])){
					$arrKeys=array_keys($arrFile);
					$nCount=count($arrFile['name']);
					for($nI=0;$nI<$nCount;$nI++){
						foreach($arrKeys as $nKey){
							$arrFileInfo[$nI][$nKey]=$arrFile[$nKey][$nI];
						}
					}
				}else{
					$arrFileInfo=$arrFiles;
				}
				break;
			}
		}

		return $arrFileInfo;
	}

	protected function writeSafeFile($sFileStoreDir){
		if(!is_file($sFileStoreDir.'/index.html')){
			file_put_contents($sFileStoreDir.'/index.html'," ");
		}
	}

	protected function error($nErrorNo){
		switch($nErrorNo){
			case self::UPLOAD_ERR_INI_SIZE:
				$this->_sError=Q::L('上传的文件超过了 php.ini 中 upload_max_filesize 选项限制的值','__QEEPHP__@Q').' '.ini_get('upload_max_filesize');
				break;
			case self::UPLOAD_ERR_FORM_SIZE:
				$this->_sError=Q::L('超过限制字节数','__QEEPHP__@Q');
				break;
			case self::UPLOAD_ERR_PARTIAL:
				$this->_sError=Q::L('文件只有部分被上传','__QEEPHP__@Q');
				break;
			case self::UPLOAD_ERR_NO_FILE:
				$this->_sError=Q::L('文件未上传','__QEEPHP__@Q');
				break;
			case self::UPLOAD_ERR_NO_TMP_DIR:
				$this->_sError=Q::L('无法找到临时文件夹','__QEEPHP__@Q');
				break;
			case self::UPLOAD_ERR_CANT_WRITE:
				$this->_sError=Q::L('文件写入失败','__QEEPHP__@Q');
				break;
			default:
				$this->_sError=Q::L('未知上传错误！','__QEEPHP__@Q');
		}

		return;
	}

	protected function getSaveName($arrFile){
		$sRule=$this->_sSaveRule;

		if($this->_bKeepOriginalName || empty($sRule)){// 没有定义命名规则，则保持文件名不变
			$sSaveName=$arrFile['name'];
		}else{
			if(is_array($sRule) && is_callable($sRule)){
				$sSaveName=call_user_func_array($sRule,$arrFile);
			}elseif(is_string($sRule) && function_exists($sRule)){// 使用函数生成一个唯一文件标识号
				$sSaveName=$sRule().C::getExtName($arrFile['name'],2);
			}else{// 使用给定的文件名作为标识号
				$sSaveName=$sRule.'-'.md5($arrFile['name']).C::getExtName($arrFile['name'],2);
			}
		}

		if($this->_bAutoSub){// 使用子目录保存文件
			$sSaveName=$this->getSubName($arrFile).'/'.$sSaveName;
		}

		return $sSaveName;
	}

	protected function getSubName($arrFile){
		switch($this->_sSubType){
			case 'date':
				$sDir=date($this->_sDateFormat,time());
				break;
			case 'hash':
			default:
				$sName=md5($arrFile['savename']);
				$sDir='';
				for($nI=0;$nI<$this->_nHashLevel;$nI++){$sDir.=$sName{0}.'/';}
				break;
		}

		if(!is_dir($arrFile['savepath'].'/'.$sDir)){
			C::makeDir($arrFile['savepath'].'/'.$sDir);
		}

		return $sDir;
	}

	protected function check($arrFile){
		if($arrFile['error']!==0){// 文件上传失败
			$this->error($arrFile['error']);// 捕获错误代码
			return false;
		}
			
		if(!$this->checkSize($arrFile['size'])){// 文件上传成功，进行自定义规则检查&检查文件大小
			$this->_sError=Q::L('上传文件大小不符,允许的大小为%s！','__QEEPHP__@Q',null,self::getReadableFileSize($this->_nMaxSize));
			return false;
		}

		if(!$this->checkType($arrFile['type'])){// 检查文件Mime类型
			$this->_sError=Q::L('上传文件MIME类型不允许！','__QEEPHP__@Q').'<br/>'.$arrFile['type'];
			return false;
		}

		if(!$this->checkExt($arrFile['extension'])){// 检查文件类型
			$this->_sError=Q::L('上传文件类型不允许!','__QEEPHP__@Q').'<br/>'.$arrFile['extension'];
			return false;
		}

		if(!$this->checkUpload($arrFile['tmp_name'])){// 检查是否合法上传
			$this->_sError=Q::L('没有选择上传文件！','__QEEPHP__@Q');
			return false;
		}

		return true;
	}

	static public function getOriginalNameFromStoreName($sStoreName){
		$arrResult=array();

		if(preg_match('/^\d{10}\.\w+\-([\-\w\.+=]+)$/',$sStoreName,$arrResult)){
			return base64_decode(str_replace('-63-','/',$arrResult[1]));
		}else{
			return $sStoreName;
		}
	}

	public function getOriginalName($sInputName=null){
		return $_FILES[($sInputName==null)?$this->_sLastInput:$sInputName]['name'];
	}

	public function getOriginalExt($sInputName=null){
		return $this->getExt($this->getOriginalName($sInputName));
	}

	public function getOriginalType($sInputName=null){
		return $_FILES[($sInputName==null)?$this->_sLastInput:$sInputName]['type'];
	}

	public function getTempPath($sInputName=null){
		return $_FILES[($sInputName==null)?$this->_sLastInput:$sInputName]['tmp_name'];
	}

	public function getLength($sInputName=null){
		return $_FILES[($sInputName==null)?$this->_sLastInput:$sInputName]['size'];
	}

	public function setExts($MixedExtName,$bAllow=true){
		if($bAllow){
			$arr=&$this->_arrAllowExts;
		}else{
			$arr=&$this->_arrNotAllowExts;
		}

		$MixedExtName=(array)$MixedExtName;
		foreach($MixedExtName as $sExtName){
			$arr[$sExtName]=$this->getExt($sExtName);
		}
	}

	public function removeExt($sExtName,$bAllow=true){
		$arr=&$bAllow?$this->_arrAllowExts:$this->_arrNotAllowExts;
		$sExtName=$this->getExt($sExtName);
		unset($arr[$sExtName]);
	}

	public function getExts($bAllow=true){
		return $bAllow?$this->_arrAllowExts:$this->_arrNotAllowExts;
	}

	protected function checkType($sType){
		if(!empty($this->_arrNotAllowTypes) && !empty($this->_arrAllowTypes)){
			return in_array(strtolower($sType),$this->_arrNotAllowTypes)&& in_array(strtolower($sType),$this->_arrAllowTypes);
		}elseif(!empty($this->_arrNotAllowTypes)){
			return in_array(strtolower($sType),$this->_arrNotAllowTypes);
		}elseif(!empty($this->_arrAllowTypes)){
			return in_array(strtolower($sType),$this->_arrAllowTypes);
		}

		return true;
	}

	protected function checkExt($sExt){
		if(!empty($this->_arrNotAllowExts) && !empty($this->_arrAllowExts)){
			return !in_array(strtolower($sExt),$this->_arrNotAllowExts,true) && in_array(strtolower($sExt),$this->_arrAllowExts,true);
		}elseif(!empty($this->_arrNotAllowExts)){
			return !in_array(strtolower($sExt),$this->_arrNotAllowExts,true);
		}elseif(!empty($this->_arrAllowExts)){
			return in_array(strtolower($sExt),$this->_arrAllowExts,true);
		}

		return true;
	}

	protected function checkSize($nSize){
		return $nSize<=$this->_nMaxSize || -1==$this->_nMaxSize;
	}

	protected function checkUpload($sFilename){
		return is_uploaded_file($sFilename);
	}

	protected function getExt($sFilename){
		$arrPathinfo=pathinfo($sFilename);

		if(isset($arrPathinfo['extension'])){
			return $arrPathinfo['extension'];
		}else{
			return '';
		}
	}

	public function getLastInput(){
		return $this->_sLastInput;
	}

	public function getLastFileInfo(){
		return $this->_sLastFileinfo;
	}

	public function getUploadFileInfo(){
		return $this->_arrUploadFileInfo;
	}

	public function getErrorMessage(){
		return $this->_sError;
	}

	public function setAutoCreateStoreDir($bAutoCreateStoreDir=true){
		$bOldValue=$this->_bAutoCreateStoreDir;
		$this->_bAutoCreateStoreDir=$bAutoCreateStoreDir;
		return $bOldValue;
	}

	public function setWriteSafeFile($bWriteSafeFile=false){
		$bOldValue=$this->_bWriteSafeFile;
		$this->_bWriteSafeFile=$bWriteSafeFile;
		return $bOldValue;
	}

	public function setKeepOriginalName($bKeepOriginalName=true,$bUploadReplace=false){
		$this->_bKeepOriginalName=$bKeepOriginalName;
		$this->_bUploadReplace=$bUploadReplace;
	}

	public function setUploadReplace($bUploadReplace=false){
		$bOldValue=$this->_bUploadReplace;
		$this->_bUploadReplace=$bUploadReplace;
		return $bOldValue;
	}

	public function setMaxSize($nMaxSize=null){
		$nOldValue=$this->_nMaxSize;
		if($nMaxSize==null){
			$nMaxSize=self::$MAXSIZE;
		}
		$this->_nMaxSize=$nMaxSize;

		return $nOldValue;
	}

	static function getReadableFileSize($nByte){
		return C::changeFileSize($nByte);
	}

}
