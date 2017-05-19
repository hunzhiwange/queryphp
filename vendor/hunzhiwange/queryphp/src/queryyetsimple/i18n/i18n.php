<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace queryyetsimple\i18n;

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
use queryyetsimple\exception\exceptions;
use queryyetsimple\cookie\cookie;

/**
 * 语言管理类
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2016.11.18
 * @version 1.0
 */
class i18n {
    
    use dynamic_expansion;
    
    /**
     * 是否开启语言
     *
     * @var boolean
     */
    private static $booOpen = true;
    
    /**
     * 当前语言上下文
     *
     * @var string
     */
    private $sI18nName = NULL;
    
    /**
     * 默认语言上下文
     *
     * @var string
     */
    private $sDefaultI18nName = 'zh-cn';
    
    /**
     * 语言数据
     *
     * @var array
     */
    private $arrText = [ ];
    
    /**
     * 语言 cookie
     *
     * @var string
     */
    private $sCookieName = 'i18n';
    
    /**
     * 国际化参数名
     *
     * @var string
     */
    const ARGS = '~@i18n';
    
    /**
     * 配置
     *
     * @var array
     */
    protected $arrInitExpansionInstanceArgs = [ 
            'i18n\switch' => true,
            'i18n\cookie_app' => false,
            'i18n\default' => 'zh-cn',
            'i18n\auto_accept' => true 
    ];
    
    /**
     * 构造函数
     *
     * @return void
     */
    public function __construct() {
    }
    
    /**
     * 语言包状态设置
     *
     * @param boolean $booOpen            
     * @return void
     */
    public static function open($booOpen = true) {
        static::$booOpen = $booOpen;
    }
    
    /**
     * 返回语言包状态
     *
     * @return boolean
     */
    public static function getOpen() {
        return static::$booOpen;
    }
    
    /**
     * 获取语言text
     *
     * @param 当前的语言 $sValue            
     * @return string
     */
    public function getText($sValue/*Argvs*/){
        // 未开启直接返回
        if (! static::$booOpen) {
            if (func_num_args () > 1) { // 代入参数
                $sValue = call_user_func_array ( 'sprintf', func_get_args () );
            }
            return $sValue;
        }
        
        // 开启读取语言包
        $sContext = $this->getContext ();
        $sValue = $sContext && isset ( $this->arrText [$sContext] [$sValue] ) ? $this->arrText [$sContext] [$sValue] : $sValue;
        if (func_num_args () > 1) {
            $arrArgs = func_get_args ();
            $arrArgs [0] = $sValue;
            $sValue = call_user_func_array ( 'sprintf', $arrArgs );
            unset ( $arrArgs );
        }
        return $sValue;
    }
    
    /**
     * 添加语言包
     *
     * @param $sI18nName 语言名字            
     * @param $arrData 语言包数据            
     * @return void
     */
    public function addI18n($sI18nName, $arrData = []) {
        if (! $sI18nName || ! is_string ( $sI18nName )) {
            exceptions::throwException ( 'I18n name not allowed empty!' );
        }
        
        if (array_key_exists ( $sI18nName, $this->arrText )) {
            $this->arrText [$sI18nName] = array_merge ( $this->arrText [$sI18nName], $arrData );
        } else {
            $this->arrText [$sI18nName] = $arrData;
        }
    }
    
    /**
     * 自动分析语言上下文环境
     *
     * @return string
     */
    public function parseContext() {
        if (! $this->getExpansionInstanceArgs_ ( 'i18n\switch' )) {
            $sI18nSet = $this->getExpansionInstanceArgs_ ( 'i18n\default' );
        } else {
            if ($this->getExpansionInstanceArgs_ ( 'i18n\cookie_app' ) === true) {
                $sCookieName = static::$objProjectContainer->app_name . '_i18n';
            } else {
                $sCookieName = 'i18n';
            }
            $this->setCookieName ( $sCookieName );
            
            if (isset ( $_GET [static::ARGS] )) {
                $sI18nSet = $_GET [static::ARGS];
                cookie::sets ( $sCookieName, $sI18nSet );
            } elseif ($sCookieName) {
                $sI18nSet = cookie::gets ( $sCookieName );
                if (empty ( $sI18nSet )) {
                    $sI18nSet = $this->getExpansionInstanceArgs_ ( 'i18n\default' );
                }
            } elseif ($this->getExpansionInstanceArgs_ ( 'i18n\auto_accept' ) && isset ( $_SERVER ['HTTP_ACCEPT_LANGUAGE'] )) {
                preg_match ( '/^([a-z\-]+)/i', $_SERVER ['HTTP_ACCEPT_LANGUAGE'], $arrMatches );
                $sI18nSet = $arrMatches [1];
            } else {
                $sI18nSet = $this->getExpansionInstanceArgs_ ( 'i18n\default' );
            }
        }
        $this->setDefaultContext ( $this->getExpansionInstanceArgs_ ( 'i18n\default' ) );
        $this->setContext ( $sI18nSet );
        
        return $sI18nSet;
    }
    
    /**
     * 设置当前语言包上下文环境
     *
     * @param
     *            $sI18nName
     * @return void
     */
    public function setContext($sI18nName) {
        $this->sI18nName = $sI18nName;
    }
    
    /**
     * 设置当前语言包默认上下文环境
     *
     * @param
     *            $sI18nName
     * @return void
     */
    public function setDefaultContext($sI18nName) {
        $this->sDefaultI18nName = $sI18nName;
    }
    
    /**
     * 设置 cookie 名字
     *
     * @param string $sCookieName
     *            cookie名字
     * @return void
     */
    public function setCookieName($sCookieName) {
        return $this->sCookieName == $sCookieName;
    }
    
    /**
     * 获取当前语言包默认上下文环境
     *
     * @return string
     */
    public function getDefaultContext() {
        return $this->sDefaultI18nName;
    }
    
    /**
     * 获取当前语言包 cookie 名字
     *
     * @return string
     */
    public function getCookieName() {
        return $this->sCookieName;
    }
    
    /**
     * 获取当前语言包上下文环境
     *
     * @return string
     */
    public function getContext() {
        return $this->sI18nName;
    }
}
