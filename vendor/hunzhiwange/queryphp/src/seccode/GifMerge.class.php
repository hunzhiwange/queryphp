<?php
/* [$QeePHP] (C)WindsForce TEAM Since 2010.10.04.
   Gif动画验证码生成类（Modify from Discuz!）($$)*/

!defined('Q_PATH') && exit;

class GifMerge{

	const C_FILE='C_FILE';
	const C_MEMORY='C_MEMORY';
	protected $_sVer='1.1';
	protected $_nDly=50;
	protected $_sMod=self::C_FILE;
	protected $_bFirst=true;
	protected $_bUseLoop=false;
	protected $_bTransParent=false;
	protected $_bUseGlobalIn=false;
	protected $_nX=0;
	protected $_nY=0;
	protected $_nCh=0;
	protected $_hFin=0;
	protected $_sFout='';
	protected $_nLoop=0;
	protected $_nDelay=0;
	protected $_nWidth=0;
	protected $_nHeight=0;
	protected $_nSrans1=255;
	protected $_nSrans2=255;
	protected $_nSrans3=255;
	protected $_nDisposal=2;
	protected $_nOutColorTableSize=0;
	protected $_nLocalColorTableFlag=0;
	protected $_nGlobalColorTableSize=0;
	protected $_nOutColorTableSizecode=0;
	protected $_nGlobalColorTableSizecode=0;
	protected $_arrGif=array(0x47,0x49,0x46);
	protected $_arrBuffer=array();
	protected $_arrLocalIn=array();
	protected $_arrGlobalIn=array();
	protected $_arrGlobalOut=array();
	protected $_arrLogicalScreenDescriptor=array();

	public function __construct($arrImages,$nT1,$nT2,$nT3,$nLoop,$arrDl,$arrXpos,$arrYpos,$sModel){
		if($sModel){// 临时数据储存模式
			$this->_sMod=$sModel;
		}

		if($nLoop>-1){// 是否使用循环
			$this->_nLoop=floor($nLoop-1);
			$this->_bUseLoop=true;
		}

		if($nT1>-1 && $nT2>-1 && $nT3>-1){// 颜色值
			$this->_nTrans1=$nT1;
			$this->_nTrans2=$nT2;
			$this->_nTrans3=$nT3;
			$this->_bTransParent=true;
		}

		for($nI=0;$nI<count($arrImages);$nI++){// 遍历图像文件，获取相关信息
			$arrDl[$nI]?$this->_nDelay=$arrDl[$nI]:$this->_nDelay=$this->_bDly;
			$arrXpos[$nI]?$this->_nX=$arrXpos[$nI]:$this->_nX=0;
			$arrYpos[$nI]?$this->_nY=$arrYpos[$nI]:$this->_nY=0;
			$this->startGifmergeProcess($arrImages[$nI] );
		}

		$this->_sFout.="\x3b";// 初始化图像输出
	}

	protected function startGifmergeProcess($sFp){
		// 使用文件模式储存临时数据
		if($this->_sMod==self::C_FILE){
			if(!$this->_hFin=fopen($sFp,'rb')){// 读取数据
				return;
			}
		}elseif($this->_sMod==self::C_MEMORY){// 使用内存来记录临时数据
			$this->_nCh=0;
			$this->_hFin=$sFp;
		}

		// 取得字节为6的地方的数据，用于判断是否为gif数据
		$this->getBytes(6);
		if(!$this->arrCmp($this->_arrBuffer,$this->_arrGif,3)){
			return;
		}
		
		// 取得长度为7的数据
		$this->getBytes(7);

		if($this->_bFirst){
			$this->_arrLogicalScreenDescriptor=$this->_arrBuffer;
		}

		$this->_nGlobalColorTableSizecode=$this->_arrBuffer[4]&0x07;
		$this->_nGlobalColorTableSize=2<<$this->_nGlobalColorTableSizecode;
		if($this->_arrBuffer[4]&0x80){
			$this->getBytes((3*$this->_nGlobalColorTableSize));
			for($nI=0;$nI<((3*$this->_nGlobalColorTableSize));$nI++){
				$this->_arrGlobalIn[$nI]=$this->_arrBuffer[$nI];
			}

			if($this->_nOutColorTableSize==0){
				$this->_nOutColorTableSize=$this->_nGlobalColorTableSize;
				$nOutColorTableSizecode=$this->_nGlobalColorTableSizecode;
				$this->_arrGlobalOut=$this->_arrGlobalIn;
			}

			if($this->_nGlobalColorTableSize!=$this->_nOutColorTableSize || $this->arrCmp($this->_arrGlobalOut,$this->_arrGlobalIn,(3*$this->_nGlobalColorTableSize))){
				$this->_bUseGlobalIn=true;
			}
		}

		for($bLoop=true;$bLoop;){
			$this->getBytes(1);
			switch($this->_arrBuffer[0]){
				case 0x21:// 读取扩展
					$this->readExtension();
					break;
				case 0x2c:// 读取图像描述
					$this->readImageDescriptor();
					break;
				case 0x3b:
					$bLoop=false;
				break;
				default:
					$bLoop=false;
			}
		}

		if($this->_sMod==self::C_FILE){
			fclose($this->_hFin);
		}
	}

	protected function readImageDescriptor(){
		// 取得9的长度字节内容
		$this->getBytes(9);

		$arrHead=$this->_arrBuffer;
		
		// 本地色彩类型
		$this->_nLocalColorTableFlag=($this->_arrBuffer[8]&0x80)?true:false;
		
		if($this->_nLocalColorTableFlag){
			$nSizecode=$this->_arrBuffer[8]&0x07;
			$nSize=2<<$nSizecode;
			$this->getBytes(3*$nSize);

			for($nI=0;$nI<(3*$nSize);$nI++){
				$this->_arrLocalIn[$nI]=$this->_arrBuffer[$nI];
			}

			if($this->_nOutColorTableSize==0){
				$this->_nOutColorTableSize=$nSize;
				$nOutColorTableSizecode=$nSizecode;
				for($nI=0; $nI <(3*$nSize);$nI++){
					$this->_arrGlobalOut[$nI]=$this->_arrLocalIn[$nI];
				}
			}
		}

		if($this->_bFirst){
			$this->_bFirst=false;
			$this->_sFout.="\x47\x49\x46\x38\x39\x61";

			if($this->_nWidth && $this->_nHeight){
				$this->_arrLogicalScreenDescriptor[0]=$this->_nWidth&0xFF;
				$this->_arrLogicalScreenDescriptor[1]=($this->_nWidth&0xFF00)>>8;
				$this->_arrLogicalScreenDescriptor[2]=$this->_nHeight&0xFF;
				$this->_arrLogicalScreenDescriptor[3]=($this->_nHeight&0xFF00)>>8;
			}

			$this->_arrLogicalScreenDescriptor[4]|=0x80;
			$this->_arrLogicalScreenDescriptor[5]&=0xF0;
			$this->_arrLogicalScreenDescriptor[6]|=$this->_nOutColorTableSizecode;
			$this->putBytes($this->_arrLogicalScreenDescriptor,7);
			$this->putBytes($this->_arrGlobalOut,($this->_nOutColorTableSize*3));

			if($this->_bUseLoop){
				$arrNs[0]=0x21;
				$arrNs[1]=0xFF;
				$arrNs[2]=0x0B;
				$arrNs[3]=0x4e;
				$arrNs[4]=0x45;
				$arrNs[5]=0x54;
				$arrNs[6]=0x53;
				$arrNs[7]=0x43;
				$arrNs[8]=0x41;
				$arrNs[9]=0x50;
				$arrNs[10]=0x45;
				$arrNs[11]=0x32;
				$arrNs[12]=0x2e;
				$arrNs[13]=0x30;
				$arrNs[14]=0x03;
				$arrNs[15]=0x01;
				$arrNs[16]=$this->_nLoop&255;
				$arrNs[17]=$this->_nLoop>>8;
				$arrNs[18]=0x00;
				$this->putBytes($arrNs,19);
			}
		}
			
		if($this->_bUseGlobalIn){
			$arrOutTable=$this->_arrGlobalIn;
			$nOutSize=$this->_nGlobalColorTableSize;
			$nOutSizecode=$this->_nGlobalColorTableSizecode;
		}else{
			$arrOutTable=$this->_arrGlobalOut;
			$nOutSize=$this->_nOutColorTableSize;
		}
			
		if($this->_nLocalColorTableFlag){
			if($nSize==$this->_nOutColorTableSize && !$this->arrCmp($this->_arrLocalIn,$this->_arrGlobalOut,$nSize)){
				$arrOutTable=$this->_arrGlobalOut;
				$nOutSize=$this->_nOutColorTableSize;
			}else{
				$arrOutTable=$this->_arrLocalIn;
				$nOutSize=$nSize;
				$nOutSizecode=$nSizecode;
			}
		}

		$bUseTrans=false;
		if($this->_bTransParent){
			for($nI=0;$nI<$nOutSize;$nI++){
				if($arrOutTable[3*$nI]==$this->_nTrans1 && $arrOutTable[3*$nI+1]==$this->_nTrans2 && $arrOutTable[3*$nI+2]==$this->_nTrans3){
					break;
				}
			}
			
			if($nI<$nOutSize){
				$nTransIndex=$nI;
				$bUseTrans=true;
			}
		}

		if($this->_nDelay || $bUseTrans){
			$this->_arrBuffer[0]=0x21;
			$this->_arrBuffer[1]=0xf9;
			$this->_arrBuffer[2]=0x04;
			$this->_arrBuffer[3]=($this->_nDisposal<<2)+(isset($nTransIndex) && $nTransIndex?1:0);
			$this->_arrBuffer[4]=$this->_nDelay&0xff;
			$this->_arrBuffer[5]=($this->_nDelay&0xff00)>>8;
			$this->_arrBuffer[6]=$bUseTrans?$nTransIndex:0;
			$this->_arrBuffer[7]=0x00;
			$this->putBytes($this->_arrBuffer,8);
		}

		$this->_arrBuffer[0]=0x2c;
		$this->putBytes($this->_arrBuffer,1);
		$arrHead[0]=$this->_nX&0xff;
		$arrHead[1]=($this->_nX&0xff00)>> 8;
		$arrHead[2]=$this->_nY&0xff;
		$arrHead[3]=($this->_nY&0xff00)>> 8;
		$arrHead[8]&=0x40;

		if($arrOutTable!=$this->_arrGlobalOut){
			$arrHead[8]|=0x80;
			$arrHead[8]|=$nOutSizecode;
		}

		$this->putBytes($arrHead,9);
		if($arrOutTable!=$this->_arrGlobalOut){
			$this->putBytes($arrOutTable,(3*$nOutSize));
		}

		$this->getBytes(1);
		$this->putBytes($this->_arrBuffer,1);
		for(;;){
			$this->getBytes(1);
			$this->putBytes($this->_arrBuffer,1);
			if(($nU=$this->_arrBuffer[0])==0){
				break;
			}
			$this->getBytes($nU);
			$this->putBytes($this->_arrBuffer,$nU);
		}
	}

	protected function readExtension(){
		// 读取字节为1的地方的数据
		$this->getBytes(1);
		switch($this->_arrBuffer[0]){
			case 0xf9:
				$this->getBytes(6);
				break;
			case 0xfe:
				for(;;){
					$this->getBytes(1);
					if(($nU=$this->_arrBuffer[0])==0){
						break;
					}
					$this->getBytes($nU);
				}
				break;
			case 0x01:
					$this->getBytes(13);
					for(;;){
						$this->getBytes(0);
						if(($nU=$this->_arrBuffer[0])==0){
							break;
						}
						$this->getBytes($nU);
					}

				break;
					case 0xff:
					$this->getBytes(9);
					$this->getBytes(3);
					for(;;){
						$this->getBytes(1);
						if(!$this->_arrBuffer[0]){
							break;
						}
						$this->getBytes($this->_arrBuffer[0]);
					}
				break;
			default:
					for(;;){
						$this->getBytes(1);
						if(!$this->_arrBuffer[0]){
							break;
						}
						$this->getBytes($this->_arrBuffer[0]);
					}
			}
	}

	protected function arrCmp($arrB,$arrS,$nL){
		for($nI=0;$nI<$nL;$nI++){
			if($arrS{$nI}!=$arrB{$nI}){
				return false;
			}
		}

		return true;
	}

	protected function getBytes($nL){
		for($nI=0;$nI<$nL;$nI++){
			if($this->_sMod==self::C_FILE){// 文件方式
				$arrBin=unpack('C*',fread($this->_hFin,1));// unpack()函数从二进制字符串对数据进行解包
				$this->_arrBuffer[$nI]=$arrBin[1];
			}elseif($this->_sMod==self::C_MEMORY){
				$arrBin=unpack('C*',substr($this->_hFin,$this->_nCh,1));
				$this->_arrBuffer[$nI]=$arrBin[1];
				$this->_nCh++;// 二进制数据指针增加
			}
		}

		return $this->_arrBuffer;
	}

	protected function putBytes($arrS,$nL){
		for($nI=0;$nI<$nL;$nI++){
			$this->_sFout.=pack('C*',$arrS[$nI]);
		}
	}

	public function getAnimation(){
		return $this->_sFout;
	}

}
