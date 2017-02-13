<?php
/*
 * [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
 * ©2010-2017 http://queryphp.com All rights reserved.
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @version $$
 * @date 2017.02.13
 * @since 1.0
 */
namespace Q\option;

/**
 * 配置管理类
 *
 * @author Xiangmin Liu
 */
class option {
    
    /**
     * 配置数据
     *
     * @var array
     */
    private static $arrOption = [ ];
    
    /**
     * 获取配置
     *
     * @param string $sName
     *            配置键值
     * @param mixed $mixDefault
     *            配置默认值
     * @return string
     */
    static public function get($sName = '', $mixDefault = null) {
        if ($sName === '') {
            return self::$arrOption;
        }
        
        if (! strpos ( $sName, '.' )) {
            return array_key_exists ( $sName, self::$arrOption ) ? self::$arrOption [$sName] : $mixDefault;
        }
        
        $arrParts = explode ( '.', $sName );
        $arrOption = &self::$arrOption;
        foreach ( $arrParts as $sPart ) {
            if (! isset ( $arrOption [$sPart] )) {
                return $mixDefault;
            }
            $arrOption = &$arrOption [$sPart];
        }
        return $arrOption;
    }
    
    /**
     * 设置配置
     *
     * @param mixed $mixName
     *            配置键值
     * @param mixed $mixValue
     *            配置值
     * @param mixed $mixDefault
     *            配置默认值
     * @return
     *
     */
    static public function set($mixName, $mixValue = null, $mixDefault = null) {
        if (is_array ( $mixName )) {
            foreach ( $mixName as $sKey => $mixValue ) {
                self::set ( $sKey, $mixValue, $mixDefault );
            }
            return $GLOBALS ['~@option'] = self::$arrOption;
        } else {
            if (! strpos ( $mixName, '.' )) {
                self::$arrOption [$mixName] = $mixValue;
                return $GLOBALS ['~@option'] = self::$arrOption;
            }
            
            $arrParts = explode ( '.', $mixName );
            $nMax = count ( $arrParts ) - 1;
            $arrOption = &self::$arrOption;
            for($nI = 0; $nI <= $nMax; $nI ++) {
                $sPart = $arrParts [$nI];
                if ($nI < $nMax) {
                    if (! isset ( $arrOption [$sPart] )) {
                        $arrOption [$sPart] = [ ];
                    }
                    $arrOption = &$arrOption [$sPart];
                } else {
                    $arrOption [$sPart] = $mixValue;
                }
            }
            
            return $GLOBALS ['~@option'] = self::$arrOption;
        }
    }
    
    /**
     * 删除配置
     *
     * @param mixed $mixName
     *            配置键值
     * @return string
     */
    static public function delete($mixName = null) {
        if ($mixName === null) {
            self::$arrOption = [ ];
        } elseif (! strpos ( $mixName, '.' )) {
            unset ( self::$arrOption [$mixName] );
        } else {
            $arrParts = explode ( '.', $mixName );
            $nMax = count ( $arrParts ) - 1;
            $arrOption = &self::$arrOption;
            for($nI = 0; $nI <= $nMax; $nI ++) {
                $sPart = $arrParts [$nI];
                if ($nI < $nMax) {
                    if (! isset ( $arrOption [$sPart] )) {
                        $arrOption [$sPart] = [ ];
                    }
                    $arrOption = &$arrOption [$sPart];
                } else {
                    unset ( $arrOption [$sPart] );
                }
            }
        }
        
        $GLOBALS ['~@option'] = self::$arrOption;
        return true;
    }
}
