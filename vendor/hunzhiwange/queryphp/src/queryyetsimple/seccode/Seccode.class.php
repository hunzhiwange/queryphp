<?php
/* [$QeePHP] (C)WindsForce TEAM Since 2010.10.04.
   系统验证码（Modify from Discuz!）($$)*/

!defined('Q_PATH') && exit;

class Seccode{
	protected $_nCode;
	protected $_nWidth=0;
	protected $_nHeight=0;
	protected $_bBackground=true;
	protected $_bImageBackground=true;
	protected $_bBitMap=false;
	protected $_bAdulterate=true;
	protected $_bTtf=true;
	protected $_bTilt=true;
	protected $_bColor=true;
	protected $_bSize=true;
	protected $_bShadow=true;
	protected $_sFontPath;
	protected $_sDataPath='';
	protected $_arrFontColor;
	protected $_oIm;
	protected $_sImCodeFile='';
	protected $_oImCode=null;
	protected $_oImCodeShadow=null;
	protected $_bChineseCode=false;
	protected $_oColor=null;
	protected $_bAnimator=false;
	protected $_bNoise=false;
	protected $_bCurve=false;
	protected $_arrCodeSet='346789ABCDEFGHJKLMNPQRTUVWXY';
	const SECCODE_IMAGE_WIDTH_MAX_SIZE=160;
	const SECCODE_IMAGE_HEIGHT_MAX_SIZE=60;
	const SECCODE_IMAGE_WIDTH_MIN_SIZE=100;
	const SECCODE_IMAGE_HEIGHT_MIN_SIZE=30;
	protected $_arrDefaultOption=array(
		'seccode_image_width_size'=>160,
		'seccode_image_height_size'=>60,
		'seccode_adulterate'=>true,
		'seccode_ttf'=>true,
		'seccode_tilt'=>true,
		'seccode_color'=>true,
		'seccode_size'=>true,
		'seccode_shadow'=>true,
		'seccode_fontpath'=>'',
		'seccode_datapath'=>'',
		'seccode_chinesecode'=>false,
		'seccode_animator'=>false,
		'seccode_tupe'=>1,
		'seccode_norise'=>false,
		'seccode_curve'=>false,
		'seccode_codeset'=>array(),
		'seccode_fontsize'=>25,
		'seccode_background'=>true,
		'seccode_image_background'=>true,
		'seccode_bitmap'=>false,
	);

	public function __construct($arrOption=null){
		$this->_arrDefaultOption['seccode_fontpath']=Q_PATH.'/Resource_/Images/Seccode/Fonts';
		$this->_arrDefaultOption['seccode_datapath']=Q_PATH.'/Resource_/Images/Seccode';

		if(!empty($arrOption)){
			$arrDefaultOption=array_merge($this->_arrDefaultOption,$arrOption);
		}else{
			$arrDefaultOption=$this->_arrDefaultOption;
		}

		return $this->setWidth($arrDefaultOption['seccode_image_width_size'])// 验证码宽度
			->setHeight($arrDefaultOption['seccode_image_height_size']) // 验证码高度
			->setAdulterate($arrDefaultOption['seccode_adulterate']) // 随机背景图形
			->setTtf($arrDefaultOption['seccode_ttf'])// 随机TTF字体
			->setTilt($arrDefaultOption['seccode_tilt'])//随机倾斜度
			->setColor($arrDefaultOption['seccode_color'])//随机颜色
			->setSize($arrDefaultOption['seccode_size'])//随机大小
			->setShadow($arrDefaultOption['seccode_shadow'])//文字阴影
			->setFontPath($arrDefaultOption['seccode_fontpath'])// 字体路径
			->setDataPath($arrDefaultOption['seccode_datapath'])// 验证码数据地址
			->setChineseCode($arrDefaultOption['seccode_chinesecode'])// 是否使用中文验证码
			->setAnimator($arrDefaultOption['seccode_animator'])//是否开启动画
			->setNorise($arrDefaultOption['seccode_norise'])// 添加背景干扰
			->setCurve($arrDefaultOption['seccode_curve'])// 添加弧线干扰
			->setCodeSet($arrDefaultOption['seccode_codeset'])// 设置干扰字符串（字母或者数字）
			->setBackground($arrDefaultOption['seccode_background'])// 设置背景图像
			->setImageBackground($arrDefaultOption['seccode_image_background'])// 是否使用系统背景图像来创建验证码背景图像
			->setBitMap($arrDefaultOption['seccode_bitmap']);// 是否使用位图创建验证码
	}

	public function setCode($nCode){
		$this->_nCode=$nCode;
		return $this;
	}

	public function setWidth($nWidth){
		$this->_nWidth=$nWidth;
		return $this;
	}

	public function setHeight($nHeight){
		$this->_nHeight=$nHeight;
		return $this;
	}

	public function setAdulterate($bValue){
		$this->_bAdulterate=$bValue;
		return $this;
	}

	public function setTtf($bValue){
		$this->_bTtf=$bValue;
		return $this;
	}

	public function setTilt( $bValue){
		$this->_bTilt=$bValue;
		return $this;
	}

	public function setColor($bValue){
		$this->_bColor=$bValue;
		return $this;
	}

	public function setShadow($bValue){
		$this->_bShadow=$bValue;
		return $this;
	}

	public function setFontPath($sPath){
		if( empty( $sPath)){
			return $this;
		}
		$this->_sFontPath=$sPath;
		return $this;
	}

	public function setSize($bSize){
		$this->_bSize=$bSize;
		return $this;
	}

	public function setDataPath($sDataPath){
		if(empty($sDataPath)){
			return $this;
		}
		$this->_sDataPath=$sDataPath;
		return $this;
	}

	public function setChineseCode($bChineseCode){
		$this->_bChineseCode=$bChineseCode;
		return $this;
	}

	public function setAnimator($bAnimator){
		$this->_bAnimator=$bAnimator;
		return $this;
	}

	public function setNorise($bNorise){
		$this->_bNorise=$bNorise;
		return $this;
	}

	public function setCurve($bCurve){
		$this->_bCurve=$bCurve;
		return $this;
	}

	public function setCodeSet($arrCodeSet){
		if(empty($arrCodeSet)){
			return $this;
		}
		$this->_arrCodeSet=$arrCodeSet;
		return $this;
	}

	public function setBackground($bBackground){
		$this->_bBackground=$bBackground;
		return $this;
	}

	public function setImageBackground($bImageBackground){
		$this->_bImageBackground=$bImageBackground;
		return $this;
	}

	public function setBitMap($bBitMap){
		$this->_bBitMap=$bBitMap;
		return $this;
	}

	public function display(){
		// 初始化高和宽度
		if($this->_nWidth<self::SECCODE_IMAGE_WIDTH_MIN_SIZE){
			$this->_nWidth=self::SECCODE_IMAGE_WIDTH_MIN_SIZE;
		}elseif($this->_nWidth>self::SECCODE_IMAGE_WIDTH_MAX_SIZE){
			$this->_nWidth=self::SECCODE_IMAGE_WIDTH_MAX_SIZE;
		}

		if($this->_nHeight<self::SECCODE_IMAGE_HEIGHT_MIN_SIZE){
			$this->_nHeight=self::SECCODE_IMAGE_HEIGHT_MIN_SIZE;
		}elseif($this->_nHeight>self::SECCODE_IMAGE_HEIGHT_MAX_SIZE){
			$this->_nHeight=self::SECCODE_IMAGE_HEIGHT_MAX_SIZE;
		}

		if(!$this->_bBitMap && function_exists('imagecreate') and function_exists('imagecolorset') 
			and function_exists('imagecopyresized') and function_exists('imagecolorallocate')
			and function_exists('imagesetpixel') and function_exists('imagechar') 
			and function_exists('imageline') and function_exists('imagecreatefromstring')
			and (function_exists('imagegif') or function_exists('imagepng') or function_exists('imagejpeg'))
		){
			$this->image();
		}else{
			$this->bitMap();
		}
	}

	protected function fileExt($sFileName){
		return trim(substr(strrchr($sFileName,'.'),1,10));
	}

	protected function image(){
		$sBgContent=$this->background();// 验证码背景

		if($this->_bAnimator && function_exists('imagegif')){// 是否开启动画验证码
			$nTrueFrame=mt_rand(1,9);
			for($nI=0;$nI<=9;$nI++){
				$this->_oIm=imagecreatefromstring($sBgContent);
				$arrX[$nI]=$arrY[$nI]=0;
				$this->_bAdulterate && $this->adulterate();

				if($nI==$nTrueFrame){
					$this->_bTtf && function_exists('imagettftext')?$this->ttfFont():$this->gifFont();
					$this->gifFont();
					$arrD[$nI]=mt_rand(250,400);
				}else{
					$this->adulterateFont();
					$arrD[$nI]=mt_rand(5,15);
				}

				if($this->_bNorise){// 添加背景干扰
					$this->writeNoise_();
				}

				if($this->_bCurve){// 添加曲线干扰
					$this->writeCurve_();
				}

				ob_start();
				imagegif($this->_oIm);
				imagedestroy($this->_oIm);
				$arrFrame[$nI]=ob_get_contents();
				ob_end_clean();
			}

			$oAnim=new GifMerge($arrFrame,255,255,255,0,$arrD,$arrX,$arrY,'C_MEMORY');
			@header('Content-type: image/gif');
			echo $oAnim->getAnimation();
		}else{
			$this->_oIm=imagecreatefromstring( $sBgContent); // 创建背景
			$this->_bAdulterate and $this->adulterate(); // 随机背景
			$this->_bTtf and function_exists('imagettftext')?$this->ttfFont():$this->textFont(); // 是否启用字体

			if($this->_bNorise){// 添加背景干扰
				$this->writeNoise_();
			}

			if($this->_bCurve){// 添加曲线干扰
				$this->writeCurve_();
			}

			if(function_exists('imagepng')){// 优先创建png图像，如果不行路过继续
				header('Content-type: image/png');
				imagepng($this->_oIm);
			}else{// 创建jpeg图像
				header('Content-type: image/jpeg');
				imagejpeg($this->_oIm,'',100);
			}

			imagedestroy($this->_oIm);
		}
	}

	protected function writeCurve_(){
		$nPx=$nPy=0;

		// 曲线前部分
		$nA=@mt_rand(1,$this->_nHeight/2);// 振幅
		$nB=@mt_rand(-$this->_nHeight/4,$this->_nHeight/4);// Y轴方向偏移量
		$nF=@mt_rand(-$this->_nHeight/4,$this->_nHeight/4);// X轴方向偏移量
		$nT=@mt_rand($this->_nHeight,$this->_nWidth*2);// 周期
		$nW=(2*M_PI)/$nT;
		$bIsBreak=mt_rand(0,1);
		$nPx1=0;// 曲线横坐标起始位置
		$nPx2=@mt_rand($this->_nWidth/2,$this->_nWidth*0.8);// 曲线横坐标结束位置

		for($nPx=$nPx1;$nPx<=$nPx2;$nPx=$nPx+0.9){
			if($nW!=0){
				$nPy=$nA*sin($nW*$nPx+$nF)+$nB+$this->_nHeight/2;// y=Asin(ωx+φ)+ b
				$nI=(int)(($this->_nWidth/4-10)/4);
				while($nI>0){
					imagesetpixel($this->_oIm,$nPx+($bIsBreak?$nI:0),$nPy+$nI,$this->_oColor);
					$nI--;
				}
			}
		}

		// 曲线后部分
		$nA=@mt_rand(1,$this->_nHeight/2);// 振幅
		$nF=@mt_rand(-$this->_nHeight/4,$this->_nHeight/4);// X轴方向偏移量
		$nT=@mt_rand($this->_nHeight,$this->_nWidth*2);  // 周期
		$nW=(2*M_PI)/$nT;
		$nB=$nPy-$nA*sin($nW*$nPx+$nF)-$this->_nHeight/2;
		$nPx1=$nPx2;
		$nPx2=$this->_nWidth;
		$bIsBreak=mt_rand(0,1);

		for($nPx=$nPx1;$nPx<=$nPx2;$nPx=$nPx+0.9){
			if($nW!=0){
				$nPy=$nA*sin($nW*$nPx+$nF)+$nB+$this->_nHeight/2;// y=Asin(ωx+φ)+ b
				$nI=(int)(($this->_nWidth/4-12)/4);
				while($nI>0){
					imagesetpixel( $this->_oIm,$nPx+($bIsBreak?$nI:0),$nPy+$nI,$this->_oColor);
					$nI--;
				}
			}
		}
	}

	protected function writeNoise_(){
		for($nI=0;$nI<10;$nI++){
			$noiseColor=imagecolorallocate($this->_oIm,mt_rand(150,225),mt_rand(150,225),mt_rand(150,225));// 杂点颜色
			for($nJ=0;$nJ<5;$nJ++){
				imagestring($this->_oIm,5,@mt_rand(-10,$this->_nWidth),@mt_rand(-10,$this->_nHeight),
					$this->_arrCodeSet[mt_rand(0,27)],/* 杂点文本为随机的字母或数字 */$noiseColor
				);
			}
		}
	}

	protected function background(){
		$this->_oIm=imagecreatetruecolor($this->_nWidth,$this->_nHeight);// 创建一个黑色的背景图像
		$oBackgroundColor=imagecolorallocate($this->_oIm,255,255,255);// 添加颜色

		$arrBackgrounds=$arrC=array();
		if($this->_bBackground && $this->_bImageBackground && function_exists('imagecreatefromjpeg') && 
			function_exists('imagecolorat') && function_exists('imagecopymerge') && 
			function_exists('imagesetpixel') && function_exists('imageSX') && 
			function_exists('imageSY')
		){
			if(($hHandle=@opendir($this->_sDataPath.'/Background'))!==false){
				while(($sBgFile=@readdir($hHandle))!==false){
					if(preg_match('/\.jpg$/i',$sBgFile)){
						$arrBackgrounds[]=$this->_sDataPath.'/Background/'.$sBgFile;
					}
				}
				@closedir($hHandle);
			}

			if($arrBackgrounds){
				$oImwm=imagecreatefromjpeg($arrBackgrounds[array_rand($arrBackgrounds)]);// 从随机背景图片中创建一个图像
				$oColorIndex=imagecolorat($oImwm,0,0);// imagecolorat取得某像素的索引值
				$arrC=imagecolorsforindex($oImwm,$oColorIndex);// imagecolorsforindex 使其可读
				$oColorIndex=imagecolorat($oImwm,1,0);
				imagesetpixel($oImwm,0,0,$oColorIndex);// 绘制像素
				$arrC[0]=$arrC['red'];
				$arrC[1]=$arrC['green'];
				$arrC[2]=$arrC['blue'];

				// imagecopymerge函数支持png透明拷贝
				imagecopymerge($this->_oIm,$oImwm,0,0,@mt_rand(0,200-$this->_nWidth),@mt_rand(0,80-$this->_nHeight),imageSX($oImwm),imageSY($oImwm),100);
				imagedestroy( $oImwm);
			}
		}

		if(!$this->_bBackground || !$arrBackgrounds){
			for($nI=0;$nI<3;$nI++){
				$arrStart[$nI]=mt_rand(200,255);
				$arrEnd[$nI]=mt_rand(100,150);
				$arrStep[$nI]=($arrEnd[$nI]-$arrStart[$nI])/$this->_nWidth;
				$arrC[$nI]=$arrStart[$nI];
			}

			for($nI=0;$nI<$this->_nWidth;$nI++){
				$oColor=imagecolorallocate($this->_oIm,$arrC[0],$arrC[1],$arrC[2]);
				imageline($this->_oIm,$nI,0,$nI-($this->_bTilt?mt_rand(-30,30):0),$this->_nHeight,$oColor);
				$arrC[0]+=$arrStep[0];
				$arrC[1]+=$arrStep[1];
				$arrC[2]+=$arrStep[2];
			}

			$arrC[0]-=20;
			$arrC[1]-=20;
			$arrC[2]-=20;
		}

		ob_start();
		if(function_exists('imagepng')){
			imagepng($this->_oIm);
		}else{
			imagejpeg($this->_oIm,'',100);
		}

		imagedestroy( $this->_oIm);
		$sBgContent=ob_get_contents();
		ob_end_clean();
		$this->_arrFontColor=$arrC;

		return $sBgContent;
	}

	protected function adulterate(){
		$nLineNums=$this->_nHeight/10;

		for($nI=0;$nI<=$nLineNums;$nI++){
			$oColor=$this->_bColor?
				imagecolorallocate($this->_oIm,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255)):
				imagecolorallocate($this->_oIm,$this->_arrFontColor[0],$this->_arrFontColor[1], $this->_arrFontColor[2]);

			$nX=@mt_rand(0,$this->_nWidth);
			$nY=@mt_rand(0,$this->_nHeight);
			if(mt_rand(0,1)){
				imagearc($this->_oIm,$nX,$nY,@mt_rand(0,$this->_nWidth),@mt_rand(0,$this->_nHeight),mt_rand(0,360),mt_rand(0,360),$oColor);
			}else{
				$nLineMaxLong=isset($nLineMaxLong)?$nLineMaxLong:0;
				$nLineX=isset($nLineX)?$nLineX:0;
				$nLineY=isset($nLineY)?$nLineY:0;
				imageline($this->_oIm,$nX,$nY,$nLineX+@mt_rand(0,$nLineMaxLong),$nLineY+mt_rand(0,@mt_rand($this->_nHeight,$this->_nWidth)),$oColor);
			}
		}

		$this->_oColor=$oColor;
	}

	protected function ttfFont(){
		$nSeccode=$this->_nCode; // 验证码
		$sSeccodeRoot=$this->_sFontPath.($this->_bChineseCode?'/Zh-cn':'/En-us' ); // 字体路径

		$hDirs=opendir($sSeccodeRoot);// 打开验证码句柄
		$arrSeccodeTtf=array();
		while(($entry=readdir($hDirs))!==false){
			if($entry!='.' && $entry!='..' && $entry!='.svn' && in_array(strtolower($this->fileExt($entry)),array('ttf','ttc'))){
				$arrSeccodeTtf[]=$entry;
			}
		}

		if(empty($arrSeccodeTtf)){// 如果缺少字体，那么基于文字创建验证码
			$this->textFont();
			return;
		}

		if($this->_bChineseCode){
			$nSeccodeLength=2;// 验证码位数
			$nSeccode=str_split($nSeccode,3);
		}else{
			$nSeccodeLength=4;
		}

		$nWidthTotal=0;
		$arrFont=array();
		for($nI=0;$nI<$nSeccodeLength;$nI++){
			if(!isset($arrFont[$nI])){
				$arrFont[$nI]=array();
			}

			$arrFont[$nI]['font']=$sSeccodeRoot.'/'.$arrSeccodeTtf[array_rand($arrSeccodeTtf)]; // 字体
			$arrFont[$nI]['tilt']=$this->_bTilt?mt_rand(-30,30):0;// 是否启用随机倾斜度
			$arrFont[$nI]['size']=$this->_nWidth/6;// 大小 1/6图像大小

			$this->_bSize and $arrFont[$nI]['size']=@mt_rand($arrFont[$nI]['size']-$this->_nWidth/40,$arrFont[$nI]['size']+$this->_nWidth/20); // 字体大小

			$oBox=imagettfbbox($arrFont[$nI]['size'],0,$arrFont[$nI]['font'],$nSeccode[$nI]);

			$arrFont[$nI]['zheight']=max($oBox[1],$oBox[3])-min($oBox[5],$oBox[7]);

			$oBox=imagettfbbox($arrFont[$nI]['size'],$arrFont[$nI]['tilt'],$arrFont[$nI]['font'],$nSeccode[$nI]);

			$arrFont[$nI]['height']=max($oBox[1],$oBox[3])-min($oBox[5],$oBox[7]);

			$arrFont[$nI]['hd']=$arrFont[$nI]['height']-$arrFont[$nI]['zheight'];

			$arrFont[$nI]['width']=(max($oBox[2],$oBox[4])-min($oBox[0],$oBox[6]))+@mt_rand(0,$this->_nWidth/8);
			$arrFont[$nI]['width']=$arrFont[$nI]['width']>$this->_nWidth/$nSeccodeLength?$this->_nWidth/$nSeccodeLength:$arrFont[$nI]['width'];
			$nWidthTotal+=$arrFont[$nI]['width'];
		}

		// deg2rad()函数将角度转换为弧度&cos是cosine的简写.表示余弦函数
		$nX=@mt_rand($arrFont[0]['tilt']>0?cos(deg2rad(90-$arrFont[0]['tilt']))*$arrFont[0]['zheight']:1,$this->_nWidth-$nWidthTotal);

		// 是否启用随机颜色
		!$this->_bColor and $oTextColor=imagecolorallocate($this->_oIm,$this->_arrFontColor[0],$this->_arrFontColor[1],$this->_arrFontColor[2]); 

		for($nI=0;$nI<$nSeccodeLength;$nI++){
			if($this->_bColor){
				$this->_arrFontColor=array(mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
				$this->_bShadow and $oTextShadowcolor=imagecolorallocate($this->_oIm,255-$this->_arrFontColor[0],255-$this->_arrFontColor[1],255-$this->_arrFontColor[2]);
				$oTextColor=imagecolorallocate($this->_oIm,$this->_arrFontColor[0],$this->_arrFontColor[1],$this->_arrFontColor[2]);
			}elseif($this->_bShadow){
				$oTextShadowcolor=imagecolorallocate($this->_oIm,255-$this->_arrFontColor[0],255-$this->_arrFontColor[1],255-$this->_arrFontColor[2]);
			}

			$nY=$arrFont[0]['tilt']>0?@mt_rand($arrFont[$nI]['height'],$this->_nHeight):@mt_rand($arrFont[$nI]['height']-$arrFont[$nI]['hd'],$this->_nHeight-$arrFont[$nI]['hd']);
			$this->_bShadow and imagettftext($this->_oIm,$arrFont[$nI]['size'],$arrFont[$nI]['tilt'],$nX+1,$nY+1,$oTextShadowcolor,$arrFont[$nI]['font'],$nSeccode[$nI]);
			imagettftext($this->_oIm,$arrFont[$nI]['size'],$arrFont[$nI]['tilt'],$nX,$nY,$oTextColor,$arrFont[$nI]['font'],$nSeccode[$nI]);
			$nX+=$arrFont[$nI]['width'];
		}
	}

	protected function adulterateFont(){
		$sSeccodeUnits='BCEFGHJKMPQRTVWXY2346789';// 待选文字

		$nX=$this->_nWidth/4;
		$nY=$this->_nHeight/10;
		$oTextColor=imagecolorallocate($this->_oIm,$this->_arrFontColor[0],$this->_arrFontColor[1],$this->_arrFontColor[2]);// 创建背景
		
		for($nI=0;$nI<=3;$nI++){
			$sAdulterateCode=$sSeccodeUnits[mt_rand(0,23)];
			imagechar($this->_oIm,5,$nX*$nI+@mt_rand(0,$nX-10),@mt_rand($nY,$this->_nHeight-10-$nY),$sAdulterateCode,$oTextColor);
		}
	}

	protected function textFont(){
		$nSeccode=$this->_nCode;

		$nWidthTotal=0;
		for($nI=0;$nI<=3;$nI++){
			$arrFont[$nI]['width']=8+@mt_rand(0,$this->_nWidth/5-5);
			$nWidthTotal+=$arrFont[$nI]['width'];
		}

		$nX=@mt_rand(1,$this->_nWidth-$nWidthTotal);
		for($nI=0;$nI<=3;$nI++){
			$this->_oColor && $this->_arrFontColor=array(mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
			$nY=@mt_rand(0,$this->_nHeight-20);
			if($this->_bShadow){
				$oTextShadowColor=imagecolorallocate($this->_oIm,255-$this->_arrFontcolor[0],255-$this->_arrFontcolor[1],255-$this->_arrFontcolor[2]);
				imagechar($this->_oIm,5,$nX+1,$nY+1,$nSeccode[$nI],$oTextShadowColor);
			}

			$oTextColor=imagecolorallocate($this->_oIm,$this->_arrFontColor[0],$this->_arrFontColor[1],$this->_arrFontColor[2]);
			imagechar($this->_oIm,5,$nX,$nY,$this->_arrFontColor[$nX],$oTextColor);
			$nX+=$arrFont[$nI]['width'];
		}
	}

	protected function gifFont(){
		$nSeccode=$this->_nCode;

		$arrSeccodeDir=array();
		if(function_exists( 'imagecreatefromgif')){// 读取系统提供的gif数据
			$sSeccodeRoot=$this->_sDataPath.'/gif';
			$arrDirs=opendir($sSeccodeRoot);
			while(($sDir=readdir($arrDirs))!==false){
				if($sDir!='.' && $sDir!='..' && is_file($sSeccodeRoot.'/'.$sDir.'/9.gif')){
					$arrSeccodeDir[]=$sDir;
				}
			}
		}

		$nWidthTotal=0;
		for($nI=0;$nI<=3;$nI++){
			$this->_sImCodeFile=$arrSeccodeDir?$sSeccodeRoot.$arrSeccodeDir[array_rand($arrSeccodeDir)].'/'.strtolower( $nSeccode[$nI]).'.gif':'';// 获取创建字体的图片
			if(!empty( $this->_sImCodeFile) && is_file($this->_sImCodeFile)){
				$arrFont[$nI]['file']=$this->_sImCodeFile;
				$arrFont[$nI]['data']=getimagesize( $this->_sImCodeFile);
				$arrFont[$nI]['width']=$arrFont[$nI]['data'][0]+mt_rand(0,6)-4;
				$arrFont[$nI]['height']=$arrFont[$nI]['data'][1]+mt_rand(0,6)-4;
				$arrFont[$nI]['width']+=@mt_rand(0,$this->_nWidth/5-$arrFont[$nI]['width']);
				$nWidthTotal+=$arrFont[$nI]['width'];
			}else{
				$arrFont[$nI]['file']='';
				$arrFont[$nI]['width']=8+@mt_rand(0,$this->_nWidth/5-5);
				$nWidthTotal+=$arrFont[$nI]['width'];
			}
		}

		$nX=@mt_rand(1,$this->_nWidth-$nWidthTotal);
		for($nI=0;$nI<=3;$nI++){
			$this->_oColor && $this->_arrFontColor=array(mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
			if($arrFont[$nI]['file']){
				$this->_oImCode=imagecreatefromgif($arrFont[$nI]['file']);
				if($this->_bSize){
					$arrFont[$nI]['width']=@mt_rand($arrFont[$nI]['width']-$this->_nWidth/20,$arrFont[$nI]['width']+$this->_nWidth/20);
					$arrFont[$nI]['height']=@mt_rand($arrFont[$nI]['height']-$this->_nWidth/20,$arrFont[$nI]['height']+$this->_nWidth/20);
				}

				$nY=@mt_rand(0,$this->_nHeight-$arrFont[$nI]['height']);
				if($this->_bShadow){
					$this->_oImCodeShadow=$this->_oImCode;
					imagecolorset($this->_oImCodeShadow,0,255-$this->_arrFontColor[0],255-$this->_arrFontColor[1],255-$this->_arrFontColor[2]);
					imagecopyresized($this->_oIm,$this->_oImCodeShadow,$nX+1,$nY+1,0,0,$arrFont[$nI]['width'],$arrFont[$nI]['height'],$arrFont[$nI]['data'][0],$arrFont[$nI]['data'][1]);
				}

				imagecolorset($this->_oImCode,0,$this->_arrFontColor[0],$this->_arrFontColor[1],$this->_arrFontColor[2]);
				imagecopyresized($this->_oIm,$this->_oImCode,$nX,$nY,0,0,$arrFont[$nI]['width'],$arrFont[$nI]['height'],$arrFont[$nI]['data'][0],$arrFont[$nI]['data'][1]);
			}else{
				$nY=@mt_rand(0,$this->_nHeight-20);
				if($this->_bShadow){
					$oTextShadowcolor=imagecolorallocate($this->_oIm,255-$this->_arrFontColor[0],255-$this->_arrFontColor[1],255-$this->_arrFontColor[2]);
					imagechar($this->_oIm,5,$nX+1,$nY+1,$nSeccode[$nI],$oTextShadowcolor);
				}

				$oTextColor=imagecolorallocate($this->_oIm,$this->_arrFontColor[0],$this->_arrFontColor[1],$this->_arrFontColor[2]);
				imagechar($this->_oIm,5,$nX,$nY,$nSeccode[$nI],$oTextColor);
			}
			$nX+=$arrFont[$nI]['width'];
		}
	}

	protected function bitmap(){
		$arrNumbers=array(
			'B'=>array('00','fc','66','66','66','7c','66','66','fc','00'),
			'C'=>array('00','38','64','c0','c0','c0','c4','64','3c','00'),
			'E'=>array('00','fe','62','62','68','78','6a','62','fe','00'),
			'F'=>array('00','f8','60','60','68','78','6a','62','fe','00'),
			'G'=>array('00','78','cc','cc','de','c0','c4','c4','7c','00'),
			'H'=>array('00','e7','66','66','66','7e','66','66','e7','00'),
			'J'=>array('00','f8','cc','cc','cc','0c','0c','0c','7f','00'),
			'K'=>array('00','f3','66','66','7c','78','6c','66','f7','00'),
			'M'=>array('00','f7','63','6b','6b','77','77','77','e3','00'),
			'P'=>array('00','f8','60','60','7c','66','66','66','fc','00'),
			'Q'=>array('00','78','cc','cc','cc','cc','cc','cc','78','00'),
			'R'=>array('00','f3','66','6c','7c','66','66','66','fc','00'),
			'T'=>array('00','78','30','30','30','30','b4','b4','fc','00'),
			'V'=>array('00','1c','1c','36','36','36','63','63','f7','00'),
			'W'=>array('00','36','36','36','77','7f','6b','63','f7','00'),
			'X'=>array('00','f7','66','3c','18','18','3c','66','ef','00'),
			'Y'=>array('00','7e','18','18','18','3c','24','66','ef','00'),
			'2'=>array('fc','c0','60','30','18','0c','cc','cc','78','00'),
			'3'=>array('78','8c','0c','0c','38','0c','0c','8c','78','00'),
			'4'=>array('00','3e','0c','fe','4c','6c','2c','3c','1c','1c'),
			'6'=>array('78','cc','cc','cc','ec','d8','c0','60','3c','00'),
			'7'=>array('30','30','38','18','18','18','1c','8c','fc','00'),
			'8'=>array('78','cc','cc','cc','78','cc','cc','cc','78','00'),
			'9'=>array('f0','18','0c','6c','dc','cc','cc','cc','78','00')
		);

		foreach($arrNumbers as $nI=>$arrNumber){
			for($nJ=0;$nJ<6;$nJ++){
				$sA1=substr('012',mt_rand(0,2),1).substr('012345',mt_rand(0,5),1);
				$sA2=substr('012345',mt_rand(0,5),1).substr('0123',mt_rand(0,3),1);
				mt_rand(0,1)==1?array_push($arrNumbers[$nI],$sA1):array_unshift($arrNumbers[$nI],$sA1);
				mt_rand(0,1)==0?array_push($arrNumbers[$nI],$sA1):array_unshift($arrNumbers[$nI],$sA2);
			}
		}

		$arrBitmap=array();
		for($nI=0;$nI<20;$nI++){
			for($nJ=0;$nJ<=3;$nJ++){
				$nA=mt_rand(0,14);
					$nBytes=$arrNumbers[$this->_nCode[$nJ]][$nI];
				array_push($arrBitmap,$nBytes);
			}
		}

		for($nI=0;$nI<8;$nI++){
			$nA=substr('012345',mt_rand(0,2),1).substr('012345',mt_rand(0,5),1);
			array_unshift($arrBitmap,$nA);
			array_push($arrBitmap,$nA);
		}

		$sImage=pack('H*','424d9e000000000000003e000000280000002000000018000000010001000000'.
			'0000600000000000000000000000000000000000000000000000FFFFFF00'.implode('',$arrBitmap));
		
		header('Content-Type: image/bmp');
		echo $sImage;
	}

}
