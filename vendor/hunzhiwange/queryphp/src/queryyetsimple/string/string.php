<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace queryyetsimple\string;

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

use queryyetsimple\traits\dynamic\expansion as dynamic_expansion;

/**
 * 字符串
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.04.05
 * @version 4.0
 */
class string {
    
    use dynamic_expansion;
    
    /**
     * 随机字符串
     *
     * @param int $nLength            
     * @param string $sCharBox            
     * @param boolean $bNumeric            
     * @return string
     */
    public static function randString($nLength, $sCharBox = null, $bNumeric = false) {
        if ($bNumeric === true) {
            return sprintf ( '%0' . $nLength . 'd', mt_rand ( 1, pow ( 10, $nLength ) - 1 ) );
        }
        
        if ($sCharBox === null) {
            list ( $nMS, $nS ) = explode ( ' ', microtime () );
            $nCurTime = $nS + $nMS;
            
            $sCharBox = strtoupper ( md5 ( $nCurTime . rand ( 1000000000, 9999999999 ) ) );
            $sCharBox .= md5 ( $nCurTime . rand ( 1000000000, 9999999999 ) );
        }
        
        $nBoxEnd = strlen ( $sCharBox ) - 1;
        $sRet = '';
        while ( $nLength -- ) {
            $sRet .= substr ( $sCharBox, rand ( 0, $nBoxEnd ), 1 );
        }
        
        return $sRet;
    }
    
    /**
     * 字符串编码转换
     *
     * @param mixed $mixContents            
     * @param string $sFromChar            
     * @param string $sToChar            
     * @return mixed
     */
    public static function stringEncoding($mixContents, $sFromChar, $sToChar = 'utf-8') {
        if (empty ( $mixContents )) {
            return $mixContents;
        }
        
        $sFromChar = strtolower ( $sFromChar ) == 'utf8' ? 'utf-8' : strtolower ( $sFromChar );
        $sToChar = strtolower ( $sToChar ) == 'utf8' ? 'utf-8' : strtolower ( $sToChar );
        if ($sFromChar == $sToChar || (is_scalar ( $mixContents ) && ! is_string ( $mixContents ))) {
            return $mixContents;
        }
        
        if (is_string ( $mixContents )) {
            if (function_exists ( 'iconv' )) {
                return iconv ( $sFromChar, $sToChar . '//IGNORE', $mixContents );
            } elseif (function_exists ( 'mb_convert_encoding' )) {
                return mb_convert_encoding ( $mixContents, $sToChar, $sFromChar );
            } else {
                return $mixContents;
            }
        } elseif (is_array ( $mixContents )) {
            foreach ( $mixContents as $sKey => $sVal ) {
                $sKeyTwo = static::gbkToUtf8 ( $sKey, $sFromChar, $sToChar );
                $mixContents [$sKeyTwo] = static::stringEncoding ( $sVal, $sFromChar, $sToChar );
                if ($sKey != $sKeyTwo) {
                    unset ( $mixContents [$sKeyTwo] );
                }
            }
            return $mixContents;
        } else {
            return $mixContents;
        }
    }
    
    /**
     * 判断字符串是否为 UTF8
     *
     * @param string $sString            
     * @return boolean
     */
    public static function isUtf8($sString) {
        $nLength = strlen ( $sString );
        
        for($nI = 0; $nI < $nLength; $nI ++) {
            if (ord ( $sString [$nI] ) < 0x80) {
                $nN = 0;
            } elseif ((ord ( $sString [$nI] ) & 0xE0) == 0xC0) {
                $nN = 1;
            } elseif ((ord ( $sString [$nI] ) & 0xF0) == 0xE0) {
                $nN = 2;
            } elseif ((ord ( $sString [$nI] ) & 0xF0) == 0xF0) {
                $nN = 3;
            } else {
                return false;
            }
            
            for($nJ = 0; $nJ < $nN; $nJ ++) {
                if ((++ $nI == $nLength) || ((ord ( $sString [$nI] ) & 0xC0) != 0x80)) {
                    return false;
                }
            }
        }
        
        return true;
    }
    
    /**
     * 字符串截取
     *
     * @param string $sStr            
     * @param number $nStart            
     * @param number $nLength            
     * @param string $sCharset            
     * @param boolean $bSuffix            
     * @return string
     */
    public static function subString($sStr, $nStart = 0, $nLength = 255, $sCharset = "utf-8", $bSuffix = true) {
        // 对系统的字符串函数进行判断
        if (function_exists ( "mb_substr" )) {
            return mb_substr ( $sStr, $nStart, $nLength, $sCharset );
        } elseif (function_exists ( 'iconv_substr' )) {
            return iconv_substr ( $sStr, $nStart, $nLength, $sCharset );
        }
        
        // 常用几种字符串正则表达式
        $arrRe ['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $arrRe ['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $arrRe ['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $arrRe ['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        
        // 匹配
        preg_match_all ( $arrRe [$sCharset], $sStr, $arrMatch );
        $sSlice = join ( "", array_slice ( $arrMatch [0], $nStart, $nLength ) );
        
        if ($bSuffix) {
            return $sSlice . "…";
        }
        
        return $sSlice;
    }
    /**
     * 日期格式化
     *
     * @param int $nDateTemp            
     * @param string $sDateFormat            
     * @return string
     */
    public static function formatDate($nDateTemp, $sDateFormat = 'Y-m-d H:i') {
        $sReturn = '';
        
        $nSec = time () - $nDateTemp;
        $nHover = floor ( $nSec / 3600 );
        if ($nHover == 0) {
            $nMin = floor ( $nSec / 60 );
            if ($nMin == 0) {
                $sReturn = $nSec . ' ' . __ ( "秒前" );
            } else {
                $sReturn = $nMin . ' ' . __ ( "分钟前" );
            }
        } elseif ($nHover < 24) {
            $sReturn = __ ( "大约 %d 小时前", $nHover );
        } else {
            $sReturn = date ( $sDateFormat, $nDateTemp );
        }
        
        return $sReturn;
    }
    
    /**
     * 文件大小格式化
     *
     * @param int $nFileSize            
     * @param boolean $booUnit            
     * @return string
     */
    public static function formatBytes($nFileSize, $booUnit = true) {
        if ($nFileSize >= 1073741824) {
            $nFileSize = round ( $nFileSize / 1073741824, 2 ) . ($booUnit ? 'GB' : '');
        } elseif ($nFileSize >= 1048576) {
            $nFileSize = round ( $nFileSize / 1048576, 2 ) . ($booUnit ? 'MB' : '');
        } elseif ($nFileSize >= 1024) {
            $nFileSize = round ( $nFileSize / 1024, 2 ) . ($booUnit ? 'KB' : '');
        } else {
            $nFileSize = $nFileSize . ($booUnit ? __ ( '字节' ) : '');
        }
        
        return $nFileSize;
    }
    
    /**
     * 判断字符串中是否包含给定的字符开始
     *
     * @param string $strToSearched            
     * @param string $strSearch            
     * @return bool
     */
    public static function startsWith($strToSearched, $strSearch) {
        if ($strSearch != '' && strpos ( $strToSearched, $strSearch ) === 0) {
            return true;
        }
        return false;
    }
    
    /**
     * 判断字符串中是否包含给定的字符结尾
     *
     * @param string $strToSearched            
     * @param string $strSearch            
     * @return bool
     */
    public static function endsWith($strToSearched, $strSearch) {
        if (( string ) $strSearch === substr ( $strToSearched, - strlen ( $strSearch ) )) {
            return true;
        }
        return false;
    }
    
    /**
     * 判断字符串中是否包含给定的字符串集合
     *
     * @param string $strToSearched            
     * @param string $strSearch            
     * @return bool
     */
    public static function contains($strToSearched, $strSearch) {
        if ($strSearch != '' && strpos ( $strToSearched, $strSearch ) !== false) {
            return true;
        }
        return false;
    }
}
