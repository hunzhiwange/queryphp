<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace queryyetsimple\image;

<<<queryphp
##########################################################
#   ____                          ______  _   _ ______   #
#  /     \       ___  _ __  _   _ | ___ \| | | || ___ \  #
# |   (  ||(_)| / _ \| '__|| | | || |_/ /| |_| || |_/ /  #
#  \____/ |___||  __/| |   | |_| ||  __/ |  _  ||  __/   #
#       \__   | \___ |_|    \__  || |    | | | || |      #
#     Query Yet Simple      __/  |\_|    |_| |_|\_|      #
#                          |___ /  Since 2010.10.03      #
##########################################################
queryphp;

use queryyetsimple\exception\exceptions;
use queryyetsimple\traits\dynamic\expansion as dynamic_expansion;
use queryyetsimple\filesystem\directory;

/**
 * 图像处理
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2016.11.19
 * @version 1.0
 */
class image {
    
    use dynamic_expansion;
    
    /**
     * 创建缩略图
     *
     * @param string $sImage            
     * @param string $sThumbName            
     * @param string $sType            
     * @param number $nMaxWidth            
     * @param number $nMaxHeight            
     * @param boolean $bInterlace            
     * @param boolean $bFixed            
     * @param number $nQuality            
     * @return mixed
     */
    public static function thumb($sImage, $sThumbName, $sType = '', $nMaxWidth = 200, $nMaxHeight = 50, $bInterlace = true, $bFixed = false, $nQuality = 100) {
        // 获取原图信息
        $arrInfo = static::getImageInfo ( $sImage );
        
        if ($arrInfo !== false) {
            $nSrcWidth = $arrInfo ['width'];
            $nSrcHeight = $arrInfo ['height'];
            $sType = empty ( $sType ) ? $arrInfo ['type'] : $sType;
            $sType = strtolower ( $sType );
            $bInterlace = $bInterlace ? 1 : 0;
            unset ( $arrInfo );
            $nScale = min ( $nMaxWidth / $nSrcWidth, $nMaxHeight / $nSrcHeight ); // 计算缩放比例
            
            if ($bFixed === true) {
                $nWidth = $nMaxWidth;
                $nHeight = $nMaxHeight;
            } else {
                // 超过原图大小不再缩略
                if ($nScale >= 1) {
                    $nWidth = $nSrcWidth;
                    $nHeight = $nSrcHeight;
                } else { // 缩略图尺寸
                    $nWidth = ( int ) ($nSrcWidth * $nScale);
                    $nHeight = ( int ) ($nSrcHeight * $nScale);
                }
            }
            
            $sCreateFun = 'ImageCreateFrom' . ($sType == 'jpg' ? 'jpeg' : $sType); // 载入原图
            $oSrcImg = $sCreateFun ( $sImage );
            
            // 创建缩略图
            if ($sType != 'gif' && function_exists ( 'imagecreatetruecolor' )) {
                $oThumbImg = imagecreatetruecolor ( $nWidth, $nHeight );
            } else {
                $oThumbImg = imagecreate ( $nWidth, $nHeight );
            }
            
            // 复制图片
            if (function_exists ( "ImageCopyResampled" )) {
                imagecopyresampled ( $oThumbImg, $oSrcImg, 0, 0, 0, 0, $nWidth, $nHeight, $nSrcWidth, $nSrcHeight );
            } else {
                imagecopyresized ( $oThumbImg, $oSrcImg, 0, 0, 0, 0, $nWidth, $nHeight, $nSrcWidth, $nSrcHeight );
            }
            
            if ('gif' == $sType || 'png' == $sType) {
                imagealphablending ( $oThumbImg, false ); // 取消默认的混色模式
                $oBackgroundColor = imagecolorallocate ( $oThumbImg, 0, 255, 0 ); // 指派一个绿色
                imagecolortransparent ( $oThumbImg, $oBackgroundColor ); // 设置为透明色，若注释掉该行则输出绿色的图
            }
            
            // 对jpeg图形设置隔行扫描
            if ('jpg' == $sType || 'jpeg' == $sType) {
                imageinterlace ( $oThumbImg, $bInterlace );
            }
            
            if ($sType == 'png') {
                $nQuality = ceil ( $nQuality / 10 ) - 1;
                if ($nQuality < 0) {
                    $nQuality = 0;
                }
            }
            
            $sImageFun = 'image' . ($sType == 'jpg' ? 'jpeg' : $sType); // 生成图片
            $sImageFun ( $oThumbImg, $sThumbName, $nQuality );
            imagedestroy ( $oThumbImg );
            imagedestroy ( $oSrcImg );
            
            return $sThumbName;
        }
        
        return false;
    }
    
    /**
     * 预览缩略图
     *
     * @param string $sTargetFile            
     * @param number $nThumbWidth            
     * @param number $nThumbHeight            
     * @return void
     */
    public static function thumbPreview($sTargetFile, $nThumbWidth, $nThumbHeight) {
        $arrAttachInfo = @getimagesize ( $sTargetFile );
        
        list ( $nImgW, $nImgH ) = $arrAttachInfo;
        header ( 'Content-type:' . $arrAttachInfo ['mime'] );
        
        if ($nImgW >= $nThumbWidth || $nImgH >= $nThumbHeight) {
            if (function_exists ( 'imagecreatetruecolor' ) && function_exists ( 'imagecopyresampled' ) && function_exists ( 'imagejpeg' )) {
                switch ($arrAttachInfo ['mime']) {
                    case 'image/jpeg' :
                        $sImageCreateFromFunc = function_exists ( 'imagecreatefromjpeg' ) ? 'imagecreatefromjpeg' : '';
                        $sImageFunc = function_exists ( 'imagejpeg' ) ? 'imagejpeg' : '';
                        break;
                    case 'image/gif' :
                        $sImageCreateFromFunc = function_exists ( 'imagecreatefromgif' ) ? 'imagecreatefromgif' : '';
                        $sImageFunc = function_exists ( 'imagegif' ) ? 'imagegif' : '';
                        break;
                    case 'image/png' :
                        $sImageCreateFromFunc = function_exists ( 'imagecreatefrompng' ) ? 'imagecreatefrompng' : '';
                        $sImageFunc = function_exists ( 'imagepng' ) ? 'imagepng' : '';
                        break;
                }
                
                $oAttachPhoto = $sImageCreateFromFunc ( $sTargetFile );
                
                $nXRatio = $nThumbWidth / $nImgW;
                $nYRatio = $nThumbHeight / $nImgH;
                
                if (($nXRatio * $nImgH) < $nThumbHeight) {
                    $arrThumb ['height'] = ceil ( $nXRatio * $nImgH );
                    $arrThumb ['width'] = $nThumbWidth;
                } else {
                    $arrThumb ['width'] = ceil ( $nYRatio * $nImgW );
                    $arrThumb ['height'] = $nThumbHeight;
                }
                
                $oThumbPhoto = @imagecreatetruecolor ( $arrThumb ['width'], $arrThumb ['height'] );
                if ($arrAttachInfo ['mime'] != 'image/jpeg') {
                    $oAlpha = imagecolorallocatealpha ( $oThumbPhoto, 0, 0, 0, 127 );
                    imagefill ( $oThumbPhoto, 0, 0, $oAlpha );
                }
                
                @imageCopyreSampled ( $oThumbPhoto, $oAttachPhoto, 0, 0, 0, 0, $arrThumb ['width'], $arrThumb ['height'], $nImgW, $nImgH );
                if ($arrAttachInfo ['mime'] != 'image/jpeg') {
                    imagesavealpha ( $oThumbPhoto, true );
                }
                clearstatcache ();
                
                if ($arrAttachInfo ['mime'] == 'image/jpeg') {
                    $sImageFunc ( $oThumbPhoto, null, 90 );
                } else {
                    $sImageFunc ( $oThumbPhoto );
                }
            }
        } else {
            readfile ( $sTargetFile );
            exit ();
        }
    }
    
    /**
     * 图像加水印
     *
     * @param string $sBackgroundPath            
     * @param array $arrWaterArgs            
     * @param number $nWaterPos            
     * @param boolean $bDeleteBackgroupPath            
     * @return boolean
     */
    public static function imageWaterMark($sBackgroundPath, $arrWaterArgs, $nWaterPos = 0, $bDeleteBackgroupPath = true) {
        $bIsWaterImage = false;
        
        if (! empty ( $sBackgroundPath ) && is_file ( $sBackgroundPath )) { // 读取背景图片
            $arrBackgroundInfo = @getimagesize ( $sBackgroundPath );
            $nGroundWidth = $arrBackgroundInfo [0]; // 取得背景图片的宽
            $nGroundHeight = $arrBackgroundInfo [1]; // 取得背景图片的高
            switch ($arrBackgroundInfo [2]) { // 取得背景图片的格式
                case 1 :
                    $oBackgroundIm = @imagecreatefromgif ( $sBackgroundPath );
                    break;
                case 2 :
                    $oBackgroundIm = @imagecreatefromjpeg ( $sBackgroundPath );
                    break;
                case 3 :
                    $oBackgroundIm = @imagecreatefrompng ( $sBackgroundPath );
                    break;
                default :
                    exceptions::throwException ( __ ( '错误的图像格式' ), 'queryyetsimple\image\exception' );
            }
        } else {
            exceptions::throwException ( __ ( '图像 %s 为空或者不存在', $sBackgroundPath ), 'queryyetsimple\image\exception' );
        }
        
        @imagealphablending ( $oBackgroundIm, true ); // 设定图像的混色模式
        if (! empty ( $sBackgroundPath ) && is_file ( $sBackgroundPath )) {
            if ($arrWaterArgs ['type'] == 'img' && ! empty ( $arrWaterArgs ['path'] )) {
                $bIsWaterImage = true;
                $nSet = 0;
                
                $nOffset = ! empty ( $arrWaterArgs ['offset'] ) ? $arrWaterArgs ['offset'] : 0;
                if (strpos ( $arrWaterArgs, 'http://localhost/' ) == 0 || strpos ( $arrWaterArgs, 'https://localhost/' ) == 0) { // localhost 转127.0.0.1,否则将会错误
                    $arrWaterArgs ['path'] = str_replace ( 'localhost', '127.0.0.1', $arrWaterArgs ['path'] );
                }
                
                $arrWaterInfo = @getimagesize ( $arrWaterArgs ['path'] );
                $nWaterWidth = $arrWaterInfo [0]; // 取得水印图片的宽
                $nWaterHeight = $arrWaterInfo [1]; // 取得水印图片的高
                switch ($arrWaterInfo [2]) { // 取得水印图片的格式
                    case 1 :
                        $oWaterIm = @imagecreatefromgif ( $arrWaterArgs ['path'] );
                        break;
                    case 2 :
                        $oWaterIm = @imagecreatefromjpeg ( $arrWaterArgs ['path'] );
                        break;
                    case 3 :
                        $oWaterIm = @imagecreatefrompng ( $arrWaterArgs ['path'] );
                        break;
                    default :
                        exceptions::throwException ( __ ( '错误的图像格式' ), 'queryyetsimple\image\exception' );
                }
            } elseif ($arrWaterArgs ['type'] === 'text' && $arrWaterArgs ['content'] != '') {
                $sFontfileTemp = $sFontfile = isset ( $arrWaterArgs ['textFile'] ) && ! empty ( $arrWaterArgs ['textFile'] ) ? $arrWaterArgs ['textFile'] : 'Microsoft YaHei.ttf';
                $sFontfile = (! empty ( $arrWaterArgs ['textPath'] ) ? directory::tidyPath ( $arrWaterArgs ['textPath'] ) : 'C:\WINDOWS\Fonts') . '/' . $sFontfile;
                if (! is_file ( $sFontfile )) {
                    exceptions::throwException ( __ ( '字体文件 %s 无法找到', $sFontfile ), 'queryyetsimple\image\exception' );
                }
                
                $sWaterText = $arrWaterArgs ['content'];
                $nSet = 1;
                $nOffset = ! empty ( $arrWaterArgs ['offset'] ) ? $arrWaterArgs ['offset'] : 5;
                $sTextColor = empty ( $arrWaterArgs ['textColor'] ) ? '#FF0000' : $arrWaterArgs ['textColor'];
                $nTextFont = ! isset ( $arrWaterArgs ['textFont'] ) || empty ( $arrWaterArgs ['textFont'] ) ? 20 : $arrWaterArgs ['textFont'];
                $arrTemp = @imagettfbbox ( ceil ( $nTextFont ), 0, $sFontfile, $sWaterText ); // 取得使用 TrueType 字体的文本的范围
                $nWaterWidth = $arrTemp [2] - $arrTemp [6];
                $nWaterHeight = $arrTemp [3] - $arrTemp [7];
                unset ( $arrTemp );
            } else {
                exceptions::throwException ( __ ( '水印参数 type 不为 img 和 text' ), 'queryyetsimple\image\exception' );
            }
        } else {
            exceptions::throwException ( __ ( '水印参数必须为一个数组' ), 'queryyetsimple\image\exception' );
        }
        
        if (($nGroundWidth < ($nWaterWidth * 2)) || ($nGroundHeight < ($nWaterHeight * 2))) { // 如果水印占了原图一半就不搞水印了.影响浏览.抵制影响正常浏览的广告
            return true;
        }
        
        switch ($nWaterPos) {
            case 1 : // 1为顶端居左
                $nPosX = $nOffset * $nSet;
                $nPosY = ($nWaterHeight + $nOffset) * $nSet;
                break;
            case 2 : // 2为顶端居中
                $nPosX = ($nGroundWidth - $nWaterWidth) / 2;
                $nPosY = ($nWaterHeight + $nOffset) * $nSet;
                break;
            case 3 : // 3为顶端居右
                $nPosX = $nGroundWidth - $nWaterWidth - $nOffset * $nSet;
                $nPosY = ($nWaterHeight + $nOffset) * $nSet;
                break;
            case 4 : // 4为中部居左
                $nPosX = $nOffset * $nSet;
                $nPosY = ($nGroundHeight - $nWaterHeight) / 2;
                break;
            case 5 : // 5为中部居中
                $nPosX = ($nGroundWidth - $nWaterWidth) / 2;
                $nPosY = ($nGroundHeight - $nWaterHeight) / 2;
                break;
            case 6 : // 6为中部居右
                $nPosX = $nGroundWidth - $nWaterWidth - $nOffset * $nSet;
                $nPosY = ($nGroundHeight - $nWaterHeight) / 2;
                break;
            case 7 : // 7为底端居左
                $nPosX = $nOffset * $nSet;
                $nPosY = $nGroundHeight - $nWaterHeight;
                break;
            case 8 : // 8为底端居中
                $nPosX = ($nGroundWidth - $nWaterWidth) / 2;
                $nPosY = $nGroundHeight - $nWaterHeight;
                break;
            case 9 : // 9为底端居右
                $nPosX = $nGroundWidth - $nWaterWidth - $nOffset * $nSet;
                $nPosY = $nGroundHeight - $nWaterHeight;
                break;
            default : // 随机
                $nPosX = rand ( 0, ($nGroundWidth - $nWaterWidth) );
                $nPosY = rand ( 0, ($nGroundHeight - $nWaterHeight) );
                break;
        }
        
        if ($bIsWaterImage === true) { // 图片水印
            @imagealphablending ( $oWaterIm, true );
            @imagealphablending ( $oBackgroundIm, true );
            @imagecopy ( $oBackgroundIm, $oWaterIm, $nPosX, $nPosY, 0, 0, $nWaterWidth, $nWaterHeight ); // 拷贝水印到目标文件
        } else { // 文字水印
            if (! empty ( $sTextColor ) && (strlen ( $sTextColor ) == 7)) {
                $R = hexdec ( substr ( $sTextColor, 1, 2 ) );
                $G = hexdec ( substr ( $sTextColor, 3, 2 ) );
                $B = hexdec ( substr ( $sTextColor, 5 ) );
            } else {
                exceptions::throwException ( __ ( '水印文字颜色错误' ), 'queryyetsimple\image\exception' );
            }
            @imagettftext ( $oBackgroundIm, $nTextFont, 0, $nPosX, $nPosY, @imagecolorallocate ( $oBackgroundIm, $R, $G, $B ), $sFontfile, $sWaterText );
        }
        
        if ($bDeleteBackgroupPath === true) { // 生成水印后的图片
            @unlink ( $sBackgroundPath );
        }
        
        switch ($arrBackgroundInfo [2]) { // 取得背景图片的格式
            case 1 :
                @imagegif ( $oBackgroundIm, $sBackgroundPath );
                break;
            case 2 :
                @imagejpeg ( $oBackgroundIm, $sBackgroundPath );
                break;
            case 3 :
                @imagepng ( $oBackgroundIm, $sBackgroundPath );
                break;
            default :
                exceptions::throwException ( __ ( '错误的图像格式' ), 'queryyetsimple\image\exception' );
        }
        
        if (isset ( $oWaterIm )) {
            @imagedestroy ( $oWaterIm );
        }
        @imagedestroy ( $oBackgroundIm );
        
        return true;
    }
    
    /**
     * 浏览器输出图像
     *
     * @param unknown $oImage            
     * @param string $sType            
     * @param string $sFilename            
     * @return void
     */
    public static function outputImage($oImage, $sType = 'png', $sFilename = '') {
        header ( "Content-type: image/" . $sType );
        
        $sImageFun = 'image' . $sType;
        if (empty ( $sFilename )) {
            $sImageFun ( $oImage );
        } else {
            $sImageFun ( $oImage, $sFilename );
        }
        
        @imagedestroy ( $oImage );
    }
    
    /**
     * 读取远程图片
     *
     * @param string $sUrl            
     * @param string $sFilename            
     * @return void
     */
    public static function outerImage($sUrl, $sFilename) {
        if ($sUrl == '' || $sFilename == '') {
            return false;
        }
        
        // 创建文件
        if (! is_dir ( dirname ( $sFilename ) )) {
            directory::create ( dirname ( $sFilename ) );
        }
        
        // 写入文件
        ob_start ();
        readfile ( $sUrl );
        $sImg = ob_get_contents ();
        ob_end_clean ();
        $resFp = @fopen ( $sFilename, 'a' );
        fwrite ( $resFp, $sImg );
        fclose ( $resFp );
    }
    
    /**
     * 计算返回图片改变大小相对尺寸
     *
     * @param string $sImgPath            
     * @param number $nMaxWidth            
     * @param number $nMaxHeight            
     * @return array
     */
    public static function returnChangeSize($sImgPath, $nMaxWidth, $nMaxHeight) {
        $arrSize = @getimagesize ( $sImgPath );
        
        $nW = $arrSize [0];
        $nH = $arrSize [1];
        
        @$nWRatio = $nMaxWidth / $nW; // 计算缩放比例
        @$nHRatio = $nMaxHeight / $nH;
        
        $arrReturn = [ ];
        
        if (($nW <= $nMaxWidth) && ($nH <= $nMaxHeight)) { // 决定处理后的图片宽和高
            $arrReturn ['w'] = $nW;
            $arrReturn ['h'] = $nH;
        } else if (($nWRatio * $nH) < $nMaxHeight) {
            $arrReturn ['h'] = ceil ( $nWRatio * $nH );
            $arrReturn ['w'] = $nMaxWidth;
        } else {
            $arrReturn ['w'] = ceil ( $nHRatio * $nW );
            $arrReturn ['h'] = $nMaxHeight;
        }
        
        $arrReturn ['old_w'] = $nW;
        $arrReturn ['old_h'] = $nH;
        
        return $arrReturn;
    }
    
    /**
     * 取得图像信息
     *
     * @param string $sImagesPath            
     * @return mixed
     */
    public static function getImageInfo($sImagesPath) {
        $arrImageInfo = getimagesize ( $sImagesPath );
        
        if ($arrImageInfo !== false) {
            $sImageType = strtolower ( substr ( image_type_to_extension ( $arrImageInfo [2] ), 1 ) );
            $nImageSize = filesize ( $sImagesPath );
            return [ 
                    'width' => $arrImageInfo [0],
                    'height' => $arrImageInfo [1],
                    'type' => $sImageType,
                    'size' => $nImageSize,
                    'mime' => $arrImageInfo ['mime'] 
            ];
        } else {
            return false;
        }
    }
}
