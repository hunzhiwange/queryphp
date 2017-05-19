<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace queryyetsimple\xml;

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

/**
 * xml 解析类
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2016.11.19
 * @version 1.0
 */
class xml {
    
    /**
     * 函数创建 XML 解析器
     *
     * @var resource
     */
    private $resParser = NULL;
    
    /**
     * Document
     *
     * @var array
     */
    private $arrDocument;
    
    /**
     * Parent
     *
     * @var array
     */
    private $arrParent;
    
    /**
     * Stack
     *
     * @var array
     */
    private $arrStack;
    
    /**
     * LastOpenedTag
     *
     * @var array
     */
    private $sLastOpenedTag;
    
    /**
     * Data
     *
     * @var string
     */
    private $sData;
    
    /**
     * xml 反序列化
     *
     * @param string $sXml            
     * @return resource
     */
    public static function xmlUnSerialize($sXml) {
        $objXml = new self ();
        $objXml->initParser ();
        $arrData = $objXml->parse ( $sXml );
        $objXml->destroyParser ();
        return $arrData;
    }
    
    /**
     * 数据数据 xml
     *
     * @param array $arrData            
     * @param boolean $bHtmlOn            
     * @param number $nLevel            
     * @param string $sPriorKey            
     * @param string $sCharset            
     * @return string
     */
    public static function xmlSerialize(&$arrData, $bHtmlOn = true, $nLevel = 0, $sPriorKey = NULL, $sCharset = 'UTF-8') {
        if ($nLevel == 0) {
            ob_start ();
            echo '<?xml version="1.0" encoding="' . $sCharset . '"?>' . "\n" . '<root>' . "\n";
        }
        
        while ( (list ( $sKey, $sValue ) = each ( $arrData )) !== false ) {
            if (! strpos ( $sKey, ' attr' )) {
                if (is_array ( $sValue ) and array_key_exists ( 0, $sValue )) {
                    static::xmlSerialize ( $sValue, $bHtmlOn, $nLevel, $sKey, $sCharset );
                } else {
                    $sTag = $sPriorKey ? $sPriorKey : $sKey;
                    echo str_repeat ( "\t", $nLevel ), '<', $sTag;
                    if (array_key_exists ( "$sKey attr", $arrData )) {
                        while ( (list ( $sAttrName, $sAttrValue ) = each ( $arrData ["$sKey attr"] )) != '' ) {
                            echo ' ', $sAttrName, '="', ($bHtmlOn ? '<![CDATA[' : '') . $sAttrValue . ($bHtmlOn ? ']]>' : ''), '"';
                        }
                        reset ( $arrData ["$sKey attr"] );
                    }
                    
                    if (is_null ( $sValue )) {
                        echo " />\n";
                    } elseif (! is_array ( $sValue )) {
                        echo '>', ($bHtmlOn ? '<![CDATA[' : '') . $sValue . ($bHtmlOn ? ']]>' : ''), "</$sTag>\n";
                    } else {
                        echo ">\n", static::xmlSerialize ( $sValue, $bHtmlOn, $nLevel + 1, null, $sCharset ), str_repeat ( "\t", $nLevel ), "</$sTag>\n";
                    }
                }
            }
        }
        
        reset ( $arrData );
        
        if ($nLevel == 0) {
            echo '</root>';
            $sStr = ob_get_contents ();
            ob_end_clean ();
            return $sStr;
        }
    }
    
    /**
     * 分析 xml 数据
     *
     * @param string $sData            
     * @return resource
     */
    public function parse(&$sData) {
        $this->arrDocument = [ ];
        $this->arrStack = [ ];
        $this->arrParent = &$this->arrDocument;
        return xml_parse ( $this->resParser, $sData, true ) ? $this->arrDocument : NULL;
    }
    
    /**
     * 打开
     *
     * @param resource $resParser            
     * @param string $sTag            
     * @param array $arrAttributes            
     * @return void
     */
    private function open_(&$resParser, $sTag, $arrAttributes) {
        $this->sData = '';
        $this->sLastOpenedTag = $sTag;
        if (is_array ( $this->arrParent ) and array_key_exists ( $sTag, $this->arrParent )) {
            if (is_array ( $this->arrParent [$sTag] ) and array_key_exists ( 0, $this->arrParent [$sTag] )) {
                $nKey = $tthis->countNumericItems_ ( $this->arrParent [$sTag] );
            } else {
                if (array_key_exists ( "$sTag attr", $this->arrParent )) {
                    $arrValue = [ 
                            '0 attr' => &$this->arrParent ["$sTag attr"],
                            &$this->arrParent [$sTag] 
                    ];
                    unset ( $this->arrParent ["$sTag attr"] );
                } else {
                    $arrValue = [ 
                            &$this->arrParent [$sTag] 
                    ];
                }
                
                $this->arrParent [$sTag] = &$arrValue;
                $nKey = 1;
            }
            $this->arrParent = &$this->arrParent [$sTag];
        } else {
            $nKey = $sTag;
        }
        
        if ($arrAttributes) {
            $this->arrParent ["$nKey attr"] = $arrAttributes;
        }
        
        $this->arrParent = &$this->arrParent [$nKey];
        $this->arrStack [] = &$this->arrParent;
    }
    
    /**
     * 关闭
     *
     * @param resouce $resParser            
     * @param string $sTag            
     * @return void
     */
    private function close_(&$resParser, $sTag) {
        if ($this->sLastOpenedTag == $sTag) {
            $this->arrParent = $this->sData;
            $this->sLastOpenedTag = NULL;
        }
        
        array_pop ( $this->arrStack );
        if ($this->arrStack) {
            $this->arrParent = &$this->arrStack [count ( $this->arrStack ) - 1];
        }
    }
    
    /**
     * 数据设置
     *
     * @param resouce $resParser            
     * @param string $sTag            
     * @return void
     */
    private function data_(&$oParser, $sData) {
        if ($this->sLastOpenedTag != NULL) {
            $this->sData .= $sData;
        }
    }
    
    /**
     * 数字项数量
     *
     * @param array $array            
     * @return number
     */
    private function countNumericItems_(&$array) {
        return is_array ( $array ) ? count ( array_filter ( array_keys ( $array ), 'is_numeric' ) ) : 0;
    }
    
    /**
     * 初始化 xml 分析器句柄
     *
     * @return void
     */
    public function initParser() {
        $this->resParser = xml_parser_create ();
        xml_parser_set_option ( $this->resParser, XML_OPTION_CASE_FOLDING, false );
        xml_set_object ( $this->resParser, $this );
        xml_set_element_handler ( $this->resParser, 'open_', 'close_' );
        xml_set_character_data_handler ( $this->resParser, 'data_' );
    }
    
    /**
     * 关闭 xml 分析器句柄
     *
     * @return void
     */
    public function destroyParser() {
        xml_parser_free ( $this->resParser );
    }
}
