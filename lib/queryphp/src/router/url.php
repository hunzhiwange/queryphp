<?php
/*
 * [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
 * ©2010-2017 http://queryphp.com All rights reserved.
 * 
 * ##########################################################
 * #   ____                          ______  _   _ ______   #
 * #  /     \       ___  _ __  _   _ | ___ \| | | || ___ \  # 
 * # |   (  ||(_)| / _ \| '__|| | | || |_/ /| |_| || |_/ /  #
 * #  \____/ |___||  __/| |   | |_| ||  __/ |  _  ||  __/   #
 * #       \__   | \___ |_|    \__  || |    | | | || |      #
 * #     Query Yet Simple      __/  |\_|    |_| |_|\_|      #
 * #                          |___ /  Since 2010.10.03      #
 * ##########################################################
 * 
 * @author Xiangmin Liu<635750556@qq.com>
 * @version $$
 * @date 2016.11.18
 * @since 1.0
 */
namespace Q\router;

/**
 * URL分析器
 *
 * @author Xiangmin Liu
 */
class url {
    
    /**
     * url 分析实例
     *
     * @var Q\base\url
     */
    private static $oInstance = null;
    
    /**
     * 基础 url
     *
     * @var string
     */
    private static $sBaseUrl;
    
    /**
     * 请求 url
     *
     * @var string
     */
    private static $sRequestUrl;
    
    /**
     * 构造函数
     *
     * @return void
     */
    public function __construct() {
        // 非命令行模式
        if (! \Q::isCli ()) {
            $this->parseUrlWeb_ ();
        } else {
            $this->parseUrlCli_ ();
        }
        
        // 解析URL
        $this->getApp_ ( \Q\mvc\project::ARGS_APP );
        $this->getController_ ( \Q\mvc\project::ARGS_CONTROLLER );
        $this->getAction_ ( \Q\mvc\project::ARGS_ACTION );
        
        $_REQUEST = array_merge ( $_POST, $_GET );
    }
    
    /**
     * 创建 url 分析器
     *
     * @return Q\base\url
     */
    static public function run() {
        if (self::$oInstance) {
            return self::$oInstance;
        } else {
            return self::$oInstance = new self ();
        }
    }
    
    /**
     * 返回 in 参数
     *
     * @return array
     */
    public function in() {
        return $_REQUEST;
    }
    
    /**
     * web 分析 url 参数
     *
     * @return void
     */
    private function parseUrlWeb_() {
        $_SERVER ['REQUEST_URI'] = isset ( $_SERVER ['REQUEST_URI'] ) ? $_SERVER ['REQUEST_URI'] : $_SERVER ["HTTP_X_REWRITE_URL"]; // For IIS
                                                                                                                                    
        // 分析 pathinfo
        if ($GLOBALS ['~@option'] ['url_model'] == 'pathinfo') {
            // 分析pathinfo
            $this->filterPathInfo_ ();
            
            // 解析结果
            $_GET = array_merge ( $_GET, $GLOBALS ['~@option'] ['url_router_on'] === true && ($arrRouter = router::parse ()) ? $arrRouter : $this->parsePathInfo_ () );
        }
    }
    
    /**
     * 分析 cli 参数
     *
     * @return void
     */
    private function parseUrlCli_() {
        // phpunit 等不存在 $argv
        if (! isset ( $argv ) || empty ( $argv )) {
            return;
        }
        
        // 第一个为脚本自身
        array_shift ( $argv );
        
        // 继续分析
        if ($argv) {
            
            // app
            if (in_array ( $argv [0], $GLOBALS ['~@option'] ['~apps~'] )) {
                $_GET [\Q\mvc\project::ARGS_APP] = array_shift ( $argv );
            }
            
            // controller
            if ($argv) {
                $_GET [\Q\mvc\project::ARGS_CONTROLLER] = array_shift ( argv );
            }
            
            // 方法
            if ($argv) {
                $_GET [\Q\mvc\project::ARGS_ACTION] = array_shift ( argv );
            }
            
            // 剩余参数
            if ($argv) {
                for($nI = 0, $nCnt = count ( $argv ); $nI < $nCnt; $nI ++) {
                    if (isset ( $argv [$nI + 1] )) {
                        $_GET [$argv [$nI]] = ( string ) $argv [++ $nI];
                    } elseif ($nI == 0) {
                        $_GET [$_GET [\Q\mvc\project::ARGS_ACTION]] = ( string ) $argv [$nI];
                    }
                }
            }
        }
    }
    
    /**
     * 解析 pathinfo 参数
     *
     * @return array
     */
    private function parsePathInfo_() {
        $arrPathInfo = [ ];
        $sPathInfo = $_SERVER ['PATH_INFO'];
        $arrPaths = explode ( $GLOBALS ['~@option'] ['url_pathinfo_depr'], trim ( $sPathInfo, '/' ) );
        
        if (in_array ( $arrPaths [0], $GLOBALS ['~@option'] ['~apps~'] )) {
            $arrPathInfo [\Q\mvc\project::ARGS_APP] = array_shift ( $arrPaths );
        }
        
        if (! isset ( $_GET [\Q\mvc\project::ARGS_CONTROLLER] )) { // 还没有定义控制器名称
            $arrPathInfo [\Q\mvc\project::ARGS_CONTROLLER] = array_shift ( $arrPaths );
        }
        
        if (! isset ( $_GET [\Q\mvc\project::ARGS_ACTION] )) { // 还没有定义方法名称
            $arrPathInfo [\Q\mvc\project::ARGS_ACTION] = array_shift ( $arrPaths );
        }
        
        for($nI = 0, $nCnt = count ( $arrPaths ); $nI < $nCnt; $nI ++) {
            if (isset ( $arrPaths [$nI + 1] )) {
                $arrPathInfo [$arrPaths [$nI]] = ( string ) $arrPaths [++ $nI];
            }
        }
        
        return $arrPathInfo;
    }
    
    /**
     * 取回应用名
     *
     * @param string $sVar            
     * @return string
     */
    private function getApp_($sVar) {
        return $_GET [$sVar] = ! empty ( $_POST [$sVar] ) ? $_POST [$sVar] : (! empty ( $_GET [$sVar] ) ? $_GET [$sVar] : $GLOBALS ['~@option'] ['default_app']);
    }
    
    /**
     * 取回控制器名
     *
     * @param string $sVar            
     * @return string
     */
    private function getController_($sVar) {
        return $_GET [$sVar] = ! empty ( $_GET [$sVar] ) ? $_GET [$sVar] : $GLOBALS ['~@option'] ['default_controller'];
    }
    
    /**
     * 取回方法名
     *
     * @param string $sVar            
     * @return string
     */
    private function getAction_($sVar) {
        return $_GET [$sVar] = ! empty ( $_POST [$sVar] ) ? $_POST [$sVar] : (! empty ( $_GET [$sVar] ) ? $_GET [$sVar] : $GLOBALS ['~@option'] ['default_action']);
    }
    
    // ######################################################
    // ----------------- pathinfo 分析 start -----------------
    // ######################################################
    
    /**
     * pathinfo 解析入口
     *
     * @return void
     */
    private function filterPathInfo_() {
        $sPathInfo = $this->pathinfo_ ();
        $sPathInfo = $this->clearHtmlSuffix_ ( $sPathInfo );
        $sPathInfo = empty ( $sPathInfo ) ? '/' : $sPathInfo;
        $_SERVER ['PATH_INFO'] = $sPathInfo;
    }
    
    /**
     * pathinfo 兼容性分析
     *
     * @return string
     */
    private function pathinfo_() {
        if (! empty ( $_SERVER ['PATH_INFO'] )) {
            return $_SERVER ['PATH_INFO'];
        }
        
        // 分析基础 url
        $sBaseUrl = $this->baseUrl_ ();
        
        // 分析请求参数
        if (null === ($sRequestUrl = $this->requestUrl_ ())) {
            return '';
        }
        
        if (($nPos = strpos ( $sRequestUrl, '?' )) > 0) {
            $sRequestUrl = substr ( $sRequestUrl, 0, $nPos );
        }
        
        if ((null !== $sBaseUrl) && (false === ($sPathinfo = substr ( $sRequestUrl, strlen ( $sBaseUrl ) )))) {
            $sPathinfo = '';
        } elseif (null === $sBaseUrl) {
            $sPathinfo = $sRequestUrl;
        }
        
        return $sPathinfo;
    }
    
    /**
     * 分析基础 url
     *
     * @return string
     */
    private function baseUrl_() {
        // 存在返回
        if (self::$sBaseUrl) {
            return self::$sBaseUrl;
        }
        
        // 兼容分析
        $sFileName = basename ( $_SERVER ['SCRIPT_FILENAME'] );
        if (basename ( $_SERVER ['SCRIPT_NAME'] ) === $sFileName) {
            $sUrl = $_SERVER ['SCRIPT_NAME'];
        } elseif (basename ( $_SERVER ['PHP_SELF'] ) === $sFileName) {
            $sUrl = $_SERVER ['PHP_SELF'];
        } elseif (isset ( $_SERVER ['ORIG_SCRIPT_NAME'] ) && basename ( $_SERVER ['ORIG_SCRIPT_NAME'] ) === $sFileName) {
            $sUrl = $_SERVER ['ORIG_SCRIPT_NAME'];
        } else {
            $sPath = $_SERVER ['PHP_SELF'];
            $arrSegs = explode ( '/', trim ( $_SERVER ['SCRIPT_FILENAME'], '/' ) );
            $arrSegs = array_reverse ( $arrSegs );
            $nIndex = 0;
            $nLast = count ( $arrSegs );
            $sUrl = '';
            do {
                $sSeg = $arrSegs [$nIndex];
                $sUrl = '/' . $sSeg . $sUrl;
                ++ $nIndex;
            } while ( ($nLast > $nIndex) && (false !== ($nPos = strpos ( $sPath, $sUrl ))) && (0 != $nPos) );
        }
        
        // 比对请求
        $sRequestUrl = $this->requestUrl_ ();
        if (0 === strpos ( $sRequestUrl, $sUrl )) {
            return self::$sBaseUrl = $sUrl;
        }
        
        if (0 === strpos ( $sRequestUrl, dirname ( $sUrl ) )) {
            return self::$sBaseUrl = rtrim ( dirname ( $sUrl ), '/' ) . '/';
        }
        
        if (! strpos ( $sRequestUrl, basename ( $sUrl ) )) {
            return '';
        }
        
        if ((strlen ( $sRequestUrl ) >= strlen ( $sUrl )) && ((false !== ($nPos = strpos ( $sRequestUrl, $sUrl ))) && ($nPos !== 0))) {
            $sUrl = substr ( $sRequestUrl, 0, $nPos + strlen ( $sUrl ) );
        }
        
        return self::$sBaseUrl = rtrim ( $sUrl, '/' ) . '/';
    }
    
    /**
     * 请求参数
     *
     * @return string
     */
    private function requestUrl_() {
        if (self::$sRequestUrl) {
            return self::$sRequestUrl;
        }
        
        if (isset ( $_SERVER ['HTTP_X_REWRITE_URL'] )) {
            $sUrl = $_SERVER ['HTTP_X_REWRITE_URL'];
        } elseif (isset ( $_SERVER ['REQUEST_URI'] )) {
            $sUrl = $_SERVER ['REQUEST_URI'];
        } elseif (isset ( $_SERVER ['ORIG_PATH_INFO'] )) {
            $sUrl = $_SERVER ['ORIG_PATH_INFO'];
            if (! empty ( $_SERVER ['QUERY_STRING'] )) {
                $sUrl .= '?' . $_SERVER ['QUERY_STRING'];
            }
        } else {
            $sUrl = '';
        }
        
        return self::$sRequestUrl = $sUrl;
    }
    
    /**
     * 清理 url 后缀
     *
     * @param string $sVal            
     * @return string
     */
    private function clearHtmlSuffix_($sVal) {
        if ($GLOBALS ['~@option'] ['url_html_suffix'] && ! empty ( $sVal )) {
            $sSuffix = substr ( $GLOBALS ['~@option'] ['url_html_suffix'], 1 );
            $sVal = preg_replace ( '/\.' . $sSuffix . '$/', '', $sVal );
        }
        return $sVal;
    }
    
    // ######################################################
    // ------------------ pathinfo 分析 end ------------------
    // ######################################################
}
