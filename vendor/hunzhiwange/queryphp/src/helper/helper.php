<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace Q\helper;

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

use ReflectionClass;
use Q\traits\dynamic\expansion as dynamic_expansion;

/**
 * 兼容性判断
 */
//if (! class_exists ( 'Q\traits\dynamic\expansion', false ) && class_exists ( 'Q\traits\dynamic\expansion' )) {
    //require __DIR__ . '/../traits/dynamic/expansion.php';
//}

/**
 * 辅助函数
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.05.05
 * @version 1.0
 */
class helper {
    
  //  use dynamic_expansion;
    
    /**
     * 动态创建实例对象
     *
     * @param string $strClass            
     * @param array $arrArgs            
     * @return mixed
     */
    public static function newInstanceArgs($strClass, $arrArgs) {
        $objClass = new ReflectionClass ( $strClass );
        if ($objClass->getConstructor ()) {
            return $objClass->newInstanceArgs ( $arrArgs );
        } else {
            return $objClass->newInstanceWithoutConstructor ();
        }
    }
    
    /**
     * 数组数据格式化
     *
     * @param mixed $mixInput            
     * @param string $sDelimiter            
     * @param boolean $bAllowedEmpty            
     * @return mixed
     */
    public static function arrays($mixInput, $sDelimiter = ',', $bAllowedEmpty = false) {
        if (is_array ( $mixInput ) || is_string ( $mixInput )) {
            if (! is_array ( $mixInput )) {
                $mixInput = explode ( $sDelimiter, $mixInput );
            }
            
            $mixInput = array_filter ( $mixInput ); // 过滤null
            if ($bAllowedEmpty === true) {
                return $mixInput;
            } else {
                $mixInput = array_map ( 'trim', $mixInput );
                return array_filter ( $mixInput, 'strlen' );
            }
        } else {
            return $mixInput;
        }
    }
    
    /**
     * 数组合并支持 + 算法
     *
     * @param array $arrOption            
     * @param boolean $booRecursion            
     * @return array
     */
    public static function arrayMergePlus($arrOption, $booRecursion = true) {
        $arrExtend = [ ];
        foreach ( $arrOption as $strKey => $mixTemp ) {
            if (strpos ( $strKey, '+' ) === 0) {
                $arrExtend [ltrim ( $strKey, '+' )] = $mixTemp;
                unset ( $arrOption [$strKey] );
            }
        }
        foreach ( $arrExtend as $strKey => $mixTemp ) {
            if (isset ( $arrOption [$strKey] ) && is_array ( $arrOption [$strKey] ) && is_array ( $mixTemp )) {
                $arrOption [$strKey] = array_merge ( $arrOption [$strKey], $mixTemp );
                if ($booRecursion === true) {
                    $arrOption [$strKey] = static::arrayMergePlus ( $arrOption [$strKey], $booRecursion );
                }
            } else {
                $arrOption [$strKey] = $mixTemp;
            }
        }
        return $arrOption;
    }
}
