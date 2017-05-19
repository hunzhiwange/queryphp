<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace queryyetsimple\option;

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
 * 配置管理类
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.02.13
 * @version 1.0
 */
class option {
    
    use dynamic_expansion;
    
    /**
     * 配置数据
     *
     * @var array
     */
    private $arrOption = [ ];
    
    /**
     * 默认命名空间
     *
     * @var string
     */
    const DEFAUTL_NAMESPACE = 'app';
    
    /**
     * 获取配置
     *
     * @param string $sName
     *            配置键值
     * @param mixed $mixDefault
     *            配置默认值
     * @return string
     */
    public function get($sName = 'app\\', $mixDefault = null) {
        if ($sName === true) {
            return $this->arrOption;
        }
        
        $sName = $this->parseNamespace_ ( $sName );
        $strNamespace = $sName [0];
        $sName = $sName [1];
        
        if ($sName == '*') {
            return $this->arrOption [$strNamespace];
        }
        
        if (! strpos ( $sName, '.' )) {
            return array_key_exists ( $sName, $this->arrOption [$strNamespace] ) ? $this->arrOption [$strNamespace] [$sName] : $mixDefault;
        }
        
        $arrParts = explode ( '.', $sName );
        $arrOption = &$this->arrOption [$strNamespace];
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
     * @return array
     */
    public function set($mixName, $mixValue = null) {
        if (is_array ( $mixName )) {
            foreach ( $mixName as $sKey => $mixValue ) {
                $this->set ( $sKey, $mixValue );
            }
        } else {
            
            $mixName = $this->parseNamespace_ ( $mixName );
            $strNamespace = $mixName [0];
            $mixName = $mixName [1];
            
            if ($mixName == '*') {
                $this->arrOption [$strNamespace] = $mixValue;
                return;
            }
            
            if (! strpos ( $mixName, '.' )) {
                $this->arrOption [$strNamespace] [$mixName] = $mixValue;
            } else {
                $arrParts = explode ( '.', $mixName );
                $nMax = count ( $arrParts ) - 1;
                $arrOption = &$this->arrOption [$strNamespace];
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
            }
        }
    }
    
    /**
     * 删除配置
     *
     * @param string $mixName
     *            配置键值
     * @return string
     */
    public function delete($mixName) {
        $mixName = $this->parseNamespace_ ( $mixName );
        $strNamespace = $mixName [0];
        $mixName = $mixName [1];
        
        if ($mixName == '*') {
            $this->arrOption [$strNamespace] = [ ];
            return;
        }
        
        if (! strpos ( $mixName, '.' )) {
            if (isset ( $this->arrOption [$strNamespace] [$mixName] )) {
                unset ( $this->arrOption [$strNamespace] [$mixName] );
            }
        } else {
            $arrParts = explode ( '.', $mixName );
            $nMax = count ( $arrParts ) - 1;
            $arrOption = &$this->arrOption [$strNamespace];
            for($nI = 0; $nI <= $nMax; $nI ++) {
                $sPart = $arrParts [$nI];
                if ($nI < $nMax) {
                    if (! isset ( $arrOption [$sPart] )) {
                        $arrOption [$sPart] = [ ];
                    }
                    $arrOption = &$arrOption [$sPart];
                } else {
                    if (isset ( $arrOption [$sPart] )) {
                        unset ( $arrOption [$sPart] );
                    }
                }
            }
        }
    }
    
    /**
     * 初始化配置参数
     *
     * @param mixed $mixNamespace            
     * @return void
     */
    public function reset($mixNamespace = null) {
        if (is_array ( $mixNamespace )) {
            $this->arrOption = $mixNamespace;
        } elseif (is_string ( $mixNamespace )) {
            if (isset ( $this->arrOption [$mixNamespace] ))
                $this->arrOption [$mixNamespace] = [ ];
        } else {
            $this->arrOption = [ ];
        }
    }
    
    /**
     * 分析命名空间
     *
     * @param string $strName            
     * @return array
     */
    private function parseNamespace_($strName) {
        if (strpos ( $strName, '\\' )) {
            $strNamespace = explode ( '\\', $strName );
            if (empty ( $strNamespace [1] )) {
                $strNamespace [1] = '*';
            }
            $strName = $strNamespace [1];
            $strNamespace = $strNamespace [0];
        } else {
            $strNamespace = static::DEFAUTL_NAMESPACE;
        }
        
        if (! isset ( $this->arrOption [$strNamespace] ))
            $this->arrOption [$strNamespace] = [ ];
        
        return [ 
                $strNamespace,
                $strName 
        ];
    }
}
