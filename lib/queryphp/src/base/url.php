<?php
/*
 * [$QueryPHP] (C)QueryPHP.COM Since 2016.11.17.
 * URL分析器
 *
 * <The old is doyouhaobaby.com since 2010.10.04.>
 * @author dyhb<635750556@qq.com>
 * @version $$
 * @date 2016.11.18
 * @since 1.0
 */
namespace Q\base;

use Q;

/**
 * URL分析器
 *
 * @since 2016年11月19日 上午11:14:07
 * @author dyhb
 */
class url {
    protected static $_oInstance;
    protected $_sLastRouterName = null;
    protected $_arrLastRouteInfo = [ ];
    private static $_sBaseUrl;
    private static $_sBaseDir;
    private static $_sRequestUrl;
    private $_oRouter = null;
    private $_arrPathInfo = [ ];
    
    /**
     * 创建URL分析器
     *
     * @return url
     */
    static public function instance() {
        if (self::$_oInstance) {
            return self::$_oInstance;
        } else {
            return self::$_oInstance = new self ();
        }
    }
    public function parseUrl() {
        $_SERVER ['REQUEST_URI'] = isset ( $_SERVER ['REQUEST_URI'] ) ? $_SERVER ['REQUEST_URI'] : $_SERVER ["HTTP_X_REWRITE_URL"]; // For IIS
        
        $sDepr = $GLOBALS ['option'] ['url_pathinfo_depr'];
        if ($GLOBALS ['option'] ['url_model'] == 'pathinfo') {
            $this->filterPathInfo ();
            if ($GLOBALS ['option'] ['url_start_router']) {
                $arrRouterInfo = $this->getRouterInfo ();
                if (empty ( $arrRouterInfo )) {
                    $_GET = array_merge ( $this->parsePathInfo (), $_GET );
                } else {
                    $_GET = array_merge ( $this->getRouterInfo (), $_GET );
                }
            } else {
                $_GET = array_merge ( $this->parsePathInfo (), $_GET );
            }
        } else {
            if ($GLOBALS ['option'] ['url_start_router']) {
                $arrRouterInfo = $this->getRouterInfo ();
                if (! empty ( $arrRouterInfo )) {
                    $_GET = array_merge ( $arrRouterInfo, $_GET );
                } else {
                    $_GET = array_merge ( $this->getRouterInfo (), $_GET );
                }
            } else {
                $_GET = array_merge ( $this->parsePathInfo (), $_GET );
            }
        }
        
        // 行为标签
        Q::tag ( 'url' );
        
        // 解析URL
        $oApp = Q::app ();
        $oApp->app_name = $_GET ['app'] = $this->getApp ( 'app' );
        $oApp->controller_name = $_GET ['c'] = $this->getController ( 'c' );
        $oApp->action_name = $_GET ['a'] = $this->getAction ( 'a' );
        
        // 解析应用 URL 路径
        $this->parseAppPath ();
        
        $_REQUEST = array_merge ( $_POST, $_GET );
    }
    public function parseAppPath() {
        // 命令行模式直接返回
        if (Q::isCli ()) {
            return;
        }
        
        $oApp = Q::app ();
        
        // 分析 php入口文件路径
        $sAppBak = $sApp = $oApp->url_app;
        if (! $sApp) {
            /**
             * PHP 文件
             */
            if (Q::isCgi ()) {
                $arrTemp = explode ( '.php', $_SERVER ["PHP_SELF"] ); // CGI/FASTCGI模式下
                $sApp = rtrim ( str_replace ( $_SERVER ["HTTP_HOST"], '', $arrTemp [0] . '.php' ), '/' );
            } else {
                $sApp = rtrim ( $_SERVER ["SCRIPT_NAME"], '/' );
            }
            $sAppBak = $sApp;
            
            // 如果为重写模式
            if ($GLOBALS ['option'] ['url_rewrite'] === TRUE) {
                $sApp = dirname ( $sApp );
                if ($sApp == '\\') {
                    $sApp = '/';
                }
            }
        }
        
        // 网站URL根目录
        $sRoot = $oApp->url_root;
        if (! $sRoot) {
            if (strtoupper ( $_GET ['app'] ) == strtoupper ( basename ( $sAppBak ) )) {
                if ($GLOBALS ['option'] ['url_app_parentdir'] === TRUE) {
                    $sRoot = dirname ( $sAppBak );
                } else {
                    $sRoot = dirname ( dirname ( $sAppBak ) );
                }
            } else {
                $sRoot = dirname ( $sAppBak );
            }
            $sRoot = ($sRoot == '/' || $sRoot == '\\') ? '' : $sRoot;
        }
        
        // 网站公共文件目录
        $sPublic = $oApp->url_public;
        if (! $sPublic) {
            $sPublic = $sRoot . '/public';
        }
        
        $oApp->url_app = $sApp;
        $oApp->url_root = $sRoot;
        $oApp->url_public = $sPublic;
        unset ( $sApp, $sAppBak, $sRoot, $sPublic );
    }
    private function getRouterInfo() {
        if (is_null ( $this->_oRouter )) {
            $this->_oRouter = new Router ( $this );
        }
        
        $this->_oRouter->import (); // 导入路由规则
        $this->_arrLastRouteInfo = $this->_oRouter->G (); // 获取路由信息
        $this->_sLastRouterName = $this->_oRouter->getLastRouterName ();
        return $this->_arrLastRouteInfo;
    }
    public function getLastRouterName() {
        return $this->_sLastRouterName;
    }
    public function getLastRouterInfo() {
        return $this->_arrLastRouteInfo;
    }
    public function requestUrl() {
        if (self::$_sRequestUrl) {
            return self::$_sRequestUrl;
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
        
        self::$_sRequestUrl = $sUrl;
        return $sUrl;
    }
    public function baseDir() {
        if (self::$_sBaseDir) {
            return self::$_sBaseDir;
        }
        
        $sBaseUrl = $this->baseUrl ();
        if (substr ( $sBaseUrl, - 1, 1 ) == '/') {
            $sBaseDir = $sBaseUrl;
        } else {
            $sBaseDir = dirname ( $sBaseUrl );
        }
        
        self::$_sBaseDir = rtrim ( $sBaseDir, '/\\' ) . '/';
        return self::$_sBaseDir;
    }
    public function baseUrl() {
        if (self::$_sBaseUrl) {
            return self::$_sBaseUrl;
        }
        
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
        
        $sRequestUrl = $this->requestUrl ();
        if (0 === strpos ( $sRequestUrl, $sUrl )) {
            self::$_sBaseUrl = $sUrl;
            return self::$_sBaseUrl;
        }
        
        if (0 === strpos ( $sRequestUrl, dirname ( $sUrl ) )) {
            self::$_sBaseUrl = rtrim ( dirname ( $sUrl ), '/' ) . '/';
            return self::$_sBaseUrl;
        }
        
        if (! strpos ( $sRequestUrl, basename ( $sUrl ) )) {
            return '';
        }
        
        if ((strlen ( $sRequestUrl ) >= strlen ( $sUrl )) && ((false !== ($nPos = strpos ( $sRequestUrl, $sUrl ))) && ($nPos !== 0))) {
            $sUrl = substr ( $sRequestUrl, 0, $nPos + strlen ( $sUrl ) );
        }
        
        self::$_sBaseUrl = rtrim ( $sUrl, '/' ) . '/';
        return self::$_sBaseUrl;
    }
    public function pathinfo() {
        if (! empty ( $_SERVER ['PATH_INFO'] )) {
            return $_SERVER ['PATH_INFO'];
        }
        
        $sBaseUrl = $this->baseUrl ();
        
        if (null === ($sRequestUrl = $this->requestUrl ())) {
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
    public function parsePathInfo() {
        $arrPathInfo = [ ];
        $sPathInfo = &$_SERVER ['PATH_INFO'];
        $arrPaths = explode ( $GLOBALS ['option'] ['url_pathinfo_depr'], trim ( $sPathInfo, '/' ) );
        
        if (in_array ( $arrPaths [0], $GLOBALS ['option'] ['~apps~'] )) {
            $arrPathInfo ['app'] = array_shift ( $arrPaths );
        }
        
        if (! isset ( $_GET ['c'] )) { // 还没有定义控制器名称
            $arrPathInfo ['c'] = array_shift ( $arrPaths );
        }
        
        if (! isset ( $_GET ['a'] )) { // 还没有定义方法名称
            $arrPathInfo ['a'] = array_shift ( $arrPaths );
        }
        
        for($nI = 0, $nCnt = count ( $arrPaths ); $nI < $nCnt; $nI ++) {
            if (isset ( $arrPaths [$nI + 1] )) {
                $arrPathInfo [$arrPaths [$nI]] = ( string ) $arrPaths [++ $nI];
            } elseif ($nI == 0) {
                $arrPathInfo [$arrPathInfo ['a']] = ( string ) $arrPaths [$nI];
            }
        }
        
        return $arrPathInfo;
    }
    protected function getController($sVar) {
        return ! empty ( $_GET [$sVar] ) ? $_GET [$sVar] : $GLOBALS ['option'] ['default_controller'];
    }
    protected function getAction($sVar) {
        return ! empty ( $_POST [$sVar] ) ? $_POST [$sVar] : (! empty ( $_GET [$sVar] ) ? $_GET [$sVar] : $GLOBALS ['option'] ['default_action']);
    }
    protected function getApp($sVar) {
        return ! empty ( $_POST [$sVar] ) ? $_POST [$sVar] : (! empty ( $_GET [$sVar] ) ? $_GET [$sVar] : $GLOBALS ['option'] ['default_app']);
    }
    public function filterPathInfo() {
        $sPathInfo = $this->pathinfo ();
        $sPathInfo = $this->clearHtmlSuffix ( $sPathInfo );
        $sPathInfo = empty ( $sPathInfo ) ? '/' : $sPathInfo;
        $_SERVER ['PATH_INFO'] = $sPathInfo;
    }
    protected function clearHtmlSuffix($sVal) {
        if ($GLOBALS ['option'] ['url_html_suffix'] && ! empty ( $sVal )) {
            $sSuffix = substr ( $GLOBALS ['option'] ['url_html_suffix'], 1 );
            $sVal = preg_replace ( '/\.' . $sSuffix . '$/', '', $sVal );
        }
        return $sVal;
    }
}
