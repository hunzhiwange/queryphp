<?php
/*
 * [$QueryPHP] (C)QueryPHP.COM Since 2016.11.17.
 * xml 解析类
 *
 * <The old is doyouhaobaby.com since 2010.10.04.>
 * @author dyhb<635750556@qq.com>
 * @version $$
 * @date 2016.11.19
 * @since 1.0
 */
namespace Q\helper;

/**
 * xml 解析类
 *
 * 将一些配置数据封装为 xml 进行管理
 *
 * @since 2016年11月27日 下午12:41:42
 * @author dyhb
 */
class xml {
    
    /**
     * 函数创建 XML 解析器
     *
     * @var resource
     */
    private $resParser = NULL;
    
    /**
     *
     * @var array
     */
    private $arrDocument;
    
    /**
     *
     * @var array
     */
    private $arrParent;
    
    /**
     *
     * @var array
     */
    private $arrStack;
    
    /**
     *
     * @var array
     */
    private $sLastOpenedTag;
    
    /**
     *
     * @var string
     */
    private $sData;
    
    /**
     * 构造函数
     */
    public function __construct() {
        $this->resParser = xml_parser_create ();
        xml_parser_set_option ( $this->resParser, XML_OPTION_CASE_FOLDING, false );
        xml_set_object ( $this->resParser, $this );
        xml_set_element_handler ( $this->resParser, 'open', 'close' );
        xml_set_character_data_handler ( $this->resParser, 'data' );
    }
    
    /**
     * xml 反序列化
     *
     * @param string $sXml            
     */
    static public function xmlUnSerialize($sXml) {
        $oXmlParser = new Xml ();
        return $oXmlParser->parse ( $sXml );
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
    static public function xmlSerialize(&$arrData, $bHtmlOn = true, $nLevel = 0, $sPriorKey = NULL, $sCharset = 'UTF-8') {
        if ($nLevel == 0) {
            ob_start ();
            echo '<?xml version="1.0" encoding="' . $sCharset . '"?><root>', "\n";
        }
        
        while ( (list ( $sKey, $sValue ) = each ( $arrData )) !== false ) {
            if (! strpos ( $sKey, ' attr' )) {
                if (is_array ( $sValue ) and array_key_exists ( 0, $sValue )) {
                    self::xmlSerialize ( $sValue, $bHtmlOn, $nLevel, $sKey, $sCharset );
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
                        echo ">\n", self::xmlSerialize ( $sValue, $bHtmlOn, $nLevel + 1, null, $sCharset ), str_repeat ( "\t", $nLevel ), "</$sTag>\n";
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
     * @return
     *
     */
    private function parse(&$sData) {
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
     */
    private function open(&$resParser, $sTag, $arrAttributes) {
        $this->sData = '';
        $this->sLastOpenedTag = $sTag;
        if (is_array ( $this->arrParent ) and array_key_exists ( $sTag, $this->arrParent )) {
            if (is_array ( $this->arrParent [$sTag] ) and array_key_exists ( 0, $this->arrParent [$sTag] )) {
                $nKey = $tthis->countNumericItems ( $this->arrParent [$sTag] );
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
     */
    private function close(&$resParser, $sTag) {
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
     * 析构函数
     */
    public function __destruct() {
        xml_parser_free ( $this->resParser );
    }
    
    /**
     * 数字项数量
     *
     * @param array $array            
     * @return number
     */
    private function countNumericItems(&$array) {
        return is_array ( $array ) ? count ( array_filter ( array_keys ( $array ), 'is_numeric' ) ) : 0;
    }
}
