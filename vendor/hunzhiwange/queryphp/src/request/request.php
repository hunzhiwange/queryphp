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
 * @date 2016.11.19
 * @since 1.0
 */
namespace Q\request;

/**
 * 启动程序
 *
 * @author Xiangmin Liu
 */
class request {
    
    /**
     * url 请求实例
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
     * 是否初始化
     *
     * @var boolean
     */
    private static $booInit = false;
    
    /**
     * 应用名字
     *
     * @var string
     */
    private $strApp = null;
    
    /**
     * 控制器名字
     *
     * @var string
     */
    private $strController = null;
    
    /**
     * 方法名字
     *
     * @var string
     */
    private $strAction = null;
    
    /**
     * 构造函数
     *
     * @return void
     */
    public function __construct() {
        if (self::$booInit === true) {
            return $this;
        }
        self::$booInit = true;
    }
    
    /**
     * 执行请求
     *
     * @return \Q\mvc\request
     */
    public function run() {
        // 非命令行模式
        if (! \Q::isCli ()) {
            $this->parseUrlWeb_ ();
        } else {
            $this->parseUrlCli_ ();
        }
        
        // 解析URL
        $this->app ();
        $this->controller ();
        $this->action ();
        
        // 合并到 REQUEST
        $_REQUEST = array_merge ( $_POST, $_GET );
        
        // 解析项目公共 url 地址
        $this->parsePublicAndRoot_ ();
        
        // 返回自身
        return $this;
    }
    
    /**
     * 创建请求实例
     *
     * @return Q\mvc\request
     */
    static public function singleton() {
        if (self::$oInstance) {
            return self::$oInstance;
        } else {
            return self::$oInstance = new self ();
        }
    }
    
    /**
     * 返回 REQUEST 参数
     *
     * @return array
     */
    public function getRequest() {
        return $_REQUEST;
    }
    
    /**
     * 取回应用名
     *
     * @return string
     */
    public function app() {
        if ($this->strApp) {
            return $this->strApp;
        } else {
            $sVar = \Q\mvc\project::ARGS_APP;
            return $this->strApp = $_GET [$sVar] = ! empty ( $_POST [$sVar] ) ? $_POST [$sVar] : (! empty ( $_GET [$sVar] ) ? $_GET [$sVar] : $GLOBALS ['~@option'] ['default_app']);
        }
    }
    
    /**
     * 取回控制器名
     *
     * @return string
     */
    public function controller() {
        if ($this->strController) {
            return $this->strController;
        } else {
            $sVar = \Q\mvc\project::ARGS_CONTROLLER;
            return $this->strController = $_GET [$sVar] = ! empty ( $_GET [$sVar] ) ? $_GET [$sVar] : $GLOBALS ['~@option'] ['default_controller'];
        }
    }
    
    /**
     * 取回方法名
     *
     * @return string
     */
    public function action() {
        if ($this->strAction) {
            return $this->strAction;
        } else {
            $sVar = \Q\mvc\project::ARGS_ACTION;
            return $this->strAction = $_GET [$sVar] = ! empty ( $_POST [$sVar] ) ? $_POST [$sVar] : (! empty ( $_GET [$sVar] ) ? $_GET [$sVar] : $GLOBALS ['~@option'] ['default_action']);
        }
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
            $_GET = array_merge ( $_GET, $GLOBALS ['~@option'] ['url_router_on'] === true && ($arrRouter = \Q::router ()->parse ()) ? $arrRouter : $this->parsePathInfo_ () );
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
     * 解析项目公共和基础路径
     *
     * @return void
     */
    private function parsePublicAndRoot_() {
        if (\Q::isCli ()) {
            return;
        }
        
        $objProject = \Q::project ();
        $arrResult = [ ];
        
        // 分析 php 入口文件路径
        $arrResult ['enter_bak'] = $arrResult ['enter'] = $objProject->url_enter;
        if (! $arrResult ['enter']) {
            // php 文件
            if (\Q::isCgi ()) {
                $arrTemp = explode ( '.php', $_SERVER ["PHP_SELF"] ); // CGI/FASTCGI模式下
                $arrResult ['enter'] = rtrim ( str_replace ( $_SERVER ["HTTP_HOST"], '', $arrTemp [0] . '.php' ), '/' );
            } else {
                $arrResult ['enter'] = rtrim ( $_SERVER ["SCRIPT_NAME"], '/' );
            }
            $arrResult ['enter_bak'] = $arrResult ['enter'];
            
            // 如果为重写模式
            if ($GLOBALS ['~@option'] ['url_rewrite'] === TRUE) {
                $arrResult ['enter'] = dirname ( $arrResult ['enter'] );
                if ($arrResult ['enter'] == '\\') {
                    $arrResult ['enter'] = '/';
                }
            }
        }
        
        // 网站 URL 根目录
        $arrResult ['root'] = $objProject->url_root;
        if (! $arrResult ['root']) {
            $arrResult ['root'] = dirname ( $arrResult ['enter_bak'] );
            $arrResult ['root'] = ($arrResult ['root'] == '/' || $arrResult ['root'] == '\\') ? '' : $arrResult ['root'];
        }
        
        // 网站公共文件目录
        $arrResult ['public'] = $objProject->url_public;
        if (! $arrResult ['public']) {
            $arrResult ['public'] = $arrResult ['root'] . '/public';
        }
        
        // 快捷方法供 \Q::url 方法使用
        foreach ( [ 
                'enter',
                'root',
                'public' 
        ] as $sType ) {
            $GLOBALS ['~@url'] ['url_' . $sType] = $arrResult [$sType];
            $objProject->instance ( 'url_' . $sType, $arrResult [$sType] );
        }
        
        unset ( $arrResult, $objProject );
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
