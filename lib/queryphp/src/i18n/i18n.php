<?php
/*
 * [$QueryPHP] (C)QueryPHP.COM Since 2016.11.17.
 * 语言管理类
 *
 * <The old is doyouhaobaby.com since 2010.10.04.>
 * @author dyhb<635750556@qq.com>
 * @version $$
 * @date 2016.11.18
 * @since 1.0
 */
namespace Q\i18n;

use Q;

/**
 * 语言管理类
 *
 * @since 2016年11月18日 下午10:29:41
 * @author dyhb
 */
class i18n {
    
    /**
     * 当前语言上下文
     * 
     * @var string
     */
    private static $sI18nName = NULL;
    
    /**
     * 默认语言上下文
     * 
     * @var string
     */
    private static $sDefaultI18nName = 'zh-cn';
    
    /**
     * 语言数据
     * 
     * @var array
     */
    private static $arrText = [ ];
    
    /**
     * 语言 cookie
     * 
     * @var string
     */
    private static $sCookieName = 'i18n';
    
    /**
     * 获取语言text
     *
     * @param 当前的语言 $sValue            
     * @return string
     */
    static public function getText($sValue/*Argvs*/){
        $sContext = self::getContext ();
        $sValue = $sContext && isset ( self::$arrText [$sContext] [$sValue] ) ? self::$arrText [$sContext] [$sValue] : $sValue;
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
     * @return
     *
     */
    static public function addI18n($sI18nName, $arrData = []) {
        if (! $sI18nName || ! is_string ( $sI18nName )) {
            Q::errorMessage ( 'I18n name not allowed empty!' );
        }
        
        if (array_key_exists ( $sI18nName, self::$arrText )) {
            self::$arrText [$sI18nName] = array_merge ( self::$arrText [$sI18nName], $arrData );
        } else {
            self::$arrText [$sI18nName] = $arrData;
        }
    }
    
    /**
     * 自动分析语言上下文环境
     *
     * @return string
     */
    static public function parseContext() {
        $sCookieName = self::getCookieName ();
        
        if (isset ( $_GET ['~i18n~'] )) {
            $sI18nSet = $_GET ['~i18n~'];
            Q::cookie ( $sCookieName, $sI18nSet );
        } elseif ($sCookieName) {
            $sI18nSet = Q::cookie ( $sCookieName );
            if (empty ( $sI18nSet )) {
                $sI18nSet = $GLOBALS ['option'] ['i18n_default'];
            }
        } elseif ($GLOBALS ['option'] ['i18n_auto_accept'] && isset ( $_SERVER ['HTTP_ACCEPT_LANGUAGE'] )) {
            preg_match ( '/^([a-z\-]+)/i', $_SERVER ['HTTP_ACCEPT_LANGUAGE'], $arrMatches );
            $sI18nSet = $arrMatches [1];
        } else {
            $sI18nSet = $GLOBALS ['option'] ['i18n_default'];
        }
        
        self::setContext ( $sI18nSet );
        
        return $sI18nSet;
    }
    
    /**
     * 设置当前语言包上下文环境
     *
     * @param
     *            $sI18nName
     * @return
     *
     */
    static public function setContext($sI18nName) {
        self::$sI18nName = $sI18nName;
    }
    
    /**
     * 设置当前语言包默认上下文环境
     *
     * @param
     *            $sI18nName
     * @return
     *
     */
    static public function setDefaultContext($sI18nName) {
        self::$sDefaultI18nName = $sI18nName;
    }
    
    /**
     * 设置 cookie 名字
     * 
     * @param string $sCookieName
     *            cookie名字
     * @return
     *
     */
    static public function setCookieName($sCookieName) {
        return self::$sCookieName == $sCookieName;
    }
    
    /**
     * 获取当前语言包默认上下文环境
     *
     * @return
     *
     */
    static public function getDefaultContext() {
        return self::$sDefaultI18nName;
    }
    
    /**
     * 获取当前语言包 cookie 名字
     *
     * @return
     *
     */
    static public function getCookieName() {
        return self::$sCookieName;
    }
    
    /**
     * 获取当前语言包上下文环境
     *
     * @return
     *
     */
    static public function getContext() {
        return self::$sI18nName;
    }
}
