<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace queryyetsimple\http;

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

use queryyetsimple\router\router;
use queryyetsimple\traits\dynamic\expansion as dynamic_expansion;
use queryyetsimple\mvc\project;
use queryyetsimple\psr4\psr4;

/**
 * 启动程序
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2016.11.19
 * @version 1.0
 */
class request {
    
    use dynamic_expansion;
    
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
     * 配置
     *
     * @var array
     */
    protected $arrInitExpansionInstanceArgs = [ 
            '~apps~' => [ 
                    '~_~',
                    'home' 
            ],
            'default_app' => 'home',
            'default_controller' => 'index',
            'default_action' => 'index',
            'url\model' => 'pathinfo',
            'url\router_on' => true,
            'url\rewrite' => false,
            'url\html_suffix' => '.html',
            'url\pathinfo_depr' => '/' 
    ];
    
    /**
     * 构造函数
     *
     * @return void
     */
    public function __construct() {
    }
    
    /**
     * 执行请求
     *
     * @return \queryyetsimple\mvc\request
     */
    public function run() {
        // 非命令行模式
        if (! $this->isCli ()) {
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

        return $this;
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
            $sVar = \queryyetsimple\mvc\project::ARGS_APP;
            return $this->strApp = $_GET [$sVar] = ! empty ( $_POST [$sVar] ) ? $_POST [$sVar] : (! empty ( $_GET [$sVar] ) ? $_GET [$sVar] : $this->getExpansionInstanceArgs_ ( 'default_app' ));
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
            $sVar = \queryyetsimple\mvc\project::ARGS_CONTROLLER;
            return $this->strController = $_GET [$sVar] = ! empty ( $_GET [$sVar] ) ? $_GET [$sVar] : $this->getExpansionInstanceArgs_ ( 'default_controller' );
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
            $sVar = \queryyetsimple\mvc\project::ARGS_ACTION;
            return $this->strAction = $_GET [$sVar] = ! empty ( $_POST [$sVar] ) ? $_POST [$sVar] : (! empty ( $_GET [$sVar] ) ? $_GET [$sVar] : $this->getExpansionInstanceArgs_ ( 'default_action' ));
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
     * 获取 in 数据
     *
     * @param string $sKey            
     * @param string $sVar            
     * @return mixed
     */
    public function in($sKey, $sVar = 'request') {
        switch ($sVar) {
            case 'get' :
                $sVar = &$_GET;
                break;
            case 'post' :
                $sVar = &$_POST;
                break;
            case 'cookie' :
                $sVar = &$_COOKIE;
                break;
            case 'session' :
                $sVar = &$_SESSION;
                break;
            case 'request' :
                $sVar = &$_REQUEST;
                break;
            case 'files' :
                $sVar = &$_FILES;
                break;
        }
        
        return isset ( $sVar [$sKey] ) ? $sVar [$sKey] : NULL;
    }
    
    /**
     * PHP 运行模式命令行
     * link http://www.phpddt.com/php/php-sapi.html
     *
     * @return boolean
     */
    public function isCli() {
        return PHP_SAPI == 'cli' ? true : false;
    }
    
    /**
     * PHP 运行模式 cgi
     * link http://www.phpddt.com/php/php-sapi.html
     *
     * @return boolean
     */
    public function isCgi() {
        return substr ( PHP_SAPI, 0, 3 ) == 'cgi' ? true : false;
    }
    
    /**
     * 是否为 Ajax 请求行为
     *
     * @return boolean
     */
    public function isAjax() {
        return isset ( $_SERVER ['HTTP_X_REQUESTED_WITH'] ) && 'xmlhttprequest' == strtolower ( $_SERVER ['HTTP_X_REQUESTED_WITH'] );
    }
    
    /**
     * 是否为 Get 请求行为
     *
     * @return boolean
     */
    public function isGet() {
        return strtolower ( $_SERVER ['REQUEST_METHOD'] ) == 'get';
    }
    
    /**
     * 是否为 Post 请求行为
     *
     * @return boolean
     */
    public function isPost() {
        return strtolower ( $_SERVER ['REQUEST_METHOD'] ) == 'post';
    }
    
    /**
     * 是否启用 https
     *
     * @return boolean
     */
    public function isSsl() {
        if (isset ( $_SERVER ['HTTPS'] ) && ('1' == $_SERVER ['HTTPS'] || 'on' == strtolower ( $_SERVER ['HTTPS'] ))) {
            return true;
        } elseif (isset ( $_SERVER ['SERVER_PORT'] ) && ('443' == $_SERVER ['SERVER_PORT'])) {
            return true;
        }
        return false;
    }
    
    /**
     * 获取 host
     *
     * @return boolean
     */
    public function getHost() {
        return isset ( $_SERVER ['HTTP_X_FORWARDED_HOST'] ) ? $_SERVER ['HTTP_X_FORWARDED_HOST'] : (isset ( $_SERVER ['HTTP_HOST'] ) ? $_SERVER ['HTTP_HOST'] : '');
    }
    
    /**
     * 返回当前 URL 地址
     *
     * @return string
     */
    public function getCurrentUrl() {
        return (static::isSsl () ? 'https://' : 'http://') . $_SERVER ['HTTP_HOST'] . $_SERVER ['REQUEST_URI'];
    }
    
    /**
     * 获取 IP 地址
     *
     * @return string
     */
    public function getIp() {
        static $sRealip = NULL;
        
        if ($sRealip !== NULL) {
            return $sRealip;
        }
        
        if (isset ( $_SERVER )) {
            if (isset ( $_SERVER ['HTTP_X_FORWARDED_FOR'] )) {
                $arrValue = explode ( ',', $_SERVER ['HTTP_X_FORWARDED_FOR'] );
                foreach ( $arrValue as $sIp ) { // 取 X-Forwarded-For 中第一个非 unknown 的有效 IP 字符串
                    $sIp = trim ( $sIp );
                    if ($sIp != 'unknown') {
                        $sRealip = $sIp;
                        break;
                    }
                }
            } elseif (isset ( $_SERVER ['HTTP_CLIENT_IP'] )) {
                $sRealip = $_SERVER ['HTTP_CLIENT_IP'];
            } else {
                if (isset ( $_SERVER ['REMOTE_ADDR'] )) {
                    $sRealip = $_SERVER ['REMOTE_ADDR'];
                } else {
                    $sRealip = '0.0.0.0';
                }
            }
        } else {
            if (getenv ( 'HTTP_X_FORWARDED_FOR' )) {
                $sRealip = getenv ( 'HTTP_X_FORWARDED_FOR' );
            } elseif (getenv ( 'HTTP_CLIENT_IP' )) {
                $sRealip = getenv ( 'HTTP_CLIENT_IP' );
            } else {
                $sRealip = getenv ( 'REMOTE_ADDR' );
            }
        }
        
        preg_match ( "/[\d\.]{7,15}/", $sRealip, $arrOnlineip );
        $sRealip = ! empty ( $arrOnlineip [0] ) ? $arrOnlineip [0] : '0.0.0.0';
        
        return $sRealip;
    }
    
    /**
     * 返回项目容器
     *
     * @return \queryyetsimple\mvc\project
     */
    public function project() {
        return project::bootstrap ();
    }
    
    /**
     * web 分析 url 参数
     *
     * @return void
     */
    private function parseUrlWeb_() {
        $_SERVER ['REQUEST_URI'] = isset ( $_SERVER ['REQUEST_URI'] ) ? $_SERVER ['REQUEST_URI'] : $_SERVER ["HTTP_X_REWRITE_URL"]; // For IIS
                                                                                                                                    
        // 分析 pathinfo
        if ($this->getExpansionInstanceArgs_ ( 'url\model' ) == 'pathinfo') {
            // 分析pathinfo
            $this->filterPathInfo_ ();
            
            // 解析结果
            $_GET = array_merge ( $_GET, $this->getExpansionInstanceArgs_ ( 'url\router_on' ) === true && ($arrRouter = router::parses ()) ? $arrRouter : $this->parsePathInfo_ () );
        }
    }
    
    /**
     * 分析 cli 参数
     *
     * @return void
     */
    private function parseUrlCli_() {
        // console 命令行
        if (Q_CONSOLE === true) {
            // 注册 console 引导入口
            define ( 'PATH_APP_BOOTSTRAP', Q_PATH . '/console/bootstrap.php' );
            
            // 注册默认应用程序
            $_GET [\queryyetsimple\mvc\project::ARGS_APP] = '~_~@console';
            $_GET [\queryyetsimple\mvc\project::ARGS_CONTROLLER] = 'bootstrap';
            $_GET [\queryyetsimple\mvc\project::ARGS_ACTION] = 'index';
            
            return;
        }
        
        if (Q_PHPUNIT === true) {
            // 注册 phpunit 引导入口
            define ( 'PATH_APP_BOOTSTRAP', Q_PATH . '/testing/bootstrap.php' );
            
            // 注册默认应用程序
            $_GET [\queryyetsimple\mvc\project::ARGS_APP] = '~_~@testing';
            $_GET [\queryyetsimple\mvc\project::ARGS_CONTROLLER] = 'bootstrap';
            $_GET [\queryyetsimple\mvc\project::ARGS_ACTION] = 'index';
            
            return;
        }
        
        if (Q_PHPUNIT_SYSTEM === true) {
            // 注册 phpunit 内部引导入口
            define ( 'PATH_APP_BOOTSTRAP', Q_PATH . '/../../tests/bootstrap.php' );
            
            // 注册默认应用程序
            $_GET [\queryyetsimple\mvc\project::ARGS_APP] = 'tests';
            $_GET [\queryyetsimple\mvc\project::ARGS_CONTROLLER] = 'bootstrap';
            $_GET [\queryyetsimple\mvc\project::ARGS_ACTION] = 'index';
            
            // 导入 tests 命名空间
            psr4::import ( 'tests', Q_PATH . '/../../tests', [ 
                    'ignore' => [ 
                            'resource' 
                    ] 
            ] );
            
            return;
        }
        
        $arrArgv = isset ( $GLOBALS ['argv'] ) ? $GLOBALS ['argv'] : [ ];
        
        // phpunit 等不存在 $argv
        if (! isset ( $arrArgv ) || empty ( $arrArgv )) {
            return;
        }
        
        // 第一个为脚本自身
        array_shift ( $arrArgv );
        
        // 继续分析
        if ($arrArgv) {
            
            // app
            if (in_array ( $arrArgv [0], $this->getExpansionInstanceArgs_ ( '~apps~' ) )) {
                $_GET [\queryyetsimple\mvc\project::ARGS_APP] = array_shift ( $arrArgv );
            }
            
            // controller
            if ($arrArgv) {
                $_GET [\queryyetsimple\mvc\project::ARGS_CONTROLLER] = array_shift ( $arrArgv );
            }
            
            // 方法
            if ($arrArgv) {
                $_GET [\queryyetsimple\mvc\project::ARGS_ACTION] = array_shift ( $arrArgv );
            }
            
            // 剩余参数
            if ($arrArgv) {
                for($nI = 0, $nCnt = count ( $arrArgv ); $nI < $nCnt; $nI ++) {
                    if (isset ( $arrArgv [$nI + 1] )) {
                        $_GET [$arrArgv [$nI]] = ( string ) $arrArgv [++ $nI];
                    } elseif ($nI == 0) {
                        $_GET [$_GET [\queryyetsimple\mvc\project::ARGS_ACTION]] = ( string ) $arrArgv [$nI];
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
        
        $arrPaths = explode ( $this->getExpansionInstanceArgs_ ( 'url\pathinfo_depr' ), trim ( $sPathInfo, '/' ) );
        
        if (in_array ( $arrPaths [0], $this->getExpansionInstanceArgs_ ( '~apps~' ) )) {
            $arrPathInfo [\queryyetsimple\mvc\project::ARGS_APP] = array_shift ( $arrPaths );
        }
        
        if (! isset ( $_GET [\queryyetsimple\mvc\project::ARGS_CONTROLLER] )) { // 还没有定义控制器名称
            $arrPathInfo [\queryyetsimple\mvc\project::ARGS_CONTROLLER] = array_shift ( $arrPaths );
        }
        
        if (! isset ( $_GET [\queryyetsimple\mvc\project::ARGS_ACTION] )) { // 还没有定义方法名称
            $arrPathInfo [\queryyetsimple\mvc\project::ARGS_ACTION] = array_shift ( $arrPaths );
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
        if ($this->isCli ()) {
            return;
        }
        
        $objProject = $this->project ();
        $arrResult = [ ];
        
        // 分析 php 入口文件路径
        $arrResult ['enter_bak'] = $arrResult ['enter'] = $objProject->url_enter;
        if (! $arrResult ['enter']) {
            // php 文件
            if ($this->isCgi ()) {
                $arrTemp = explode ( '.php', $_SERVER ["PHP_SELF"] ); // CGI/FASTCGI模式下
                $arrResult ['enter'] = rtrim ( str_replace ( $_SERVER ["HTTP_HOST"], '', $arrTemp [0] . '.php' ), '/' );
            } else {
                $arrResult ['enter'] = rtrim ( $_SERVER ["SCRIPT_NAME"], '/' );
            }
            $arrResult ['enter_bak'] = $arrResult ['enter'];
            
            // 如果为重写模式
            if ($this->getExpansionInstanceArgs_ ( 'url\rewrite' ) === true) {
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
        
        // 快捷方法供 router::url 方法使用
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
        if (static::$sBaseUrl) {
            return static::$sBaseUrl;
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
            return static::$sBaseUrl = $sUrl;
        }
        
        if (0 === strpos ( $sRequestUrl, dirname ( $sUrl ) )) {
            return static::$sBaseUrl = rtrim ( dirname ( $sUrl ), '/' ) . '/';
        }
        
        if (! strpos ( $sRequestUrl, basename ( $sUrl ) )) {
            return '';
        }
        
        if ((strlen ( $sRequestUrl ) >= strlen ( $sUrl )) && ((false !== ($nPos = strpos ( $sRequestUrl, $sUrl ))) && ($nPos !== 0))) {
            $sUrl = substr ( $sRequestUrl, 0, $nPos + strlen ( $sUrl ) );
        }
        
        return static::$sBaseUrl = rtrim ( $sUrl, '/' ) . '/';
    }
    
    /**
     * 请求参数
     *
     * @return string
     */
    private function requestUrl_() {
        if (static::$sRequestUrl) {
            return static::$sRequestUrl;
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
        
        return static::$sRequestUrl = $sUrl;
    }
    
    /**
     * 清理 url 后缀
     *
     * @param string $sVal            
     * @return string
     */
    private function clearHtmlSuffix_($sVal) {
        if ($this->getExpansionInstanceArgs_ ( 'url\html_suffix' ) && ! empty ( $sVal )) {
            $sSuffix = substr ( $this->getExpansionInstanceArgs_ ( 'url\html_suffix' ), 1 );
            $sVal = preg_replace ( '/\.' . $sSuffix . '$/', '', $sVal );
        }
        return $sVal;
    }
    
    // ######################################################
    // ------------------ pathinfo 分析 end ------------------
    // ######################################################
}
