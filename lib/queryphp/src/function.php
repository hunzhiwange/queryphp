<?php
/*
 * [$QueryPHP] (C)QueryPHP.COM Since 2016.11.17.
 * 全局函数集
 *
 * <The old is doyouhaobaby.com since 2010.10.04.>
 * @author dyhb<635750556@qq.com>
 * @version $$
 * @date 2016.11.19
 * @since 1.0
 */
use Q\base\app, Q\helper\cookie, Q\helper\xml;

/**
 * 注册框架命名空间
 */
Q::import ( 'Q', Q_PATH, [ 
        'ignore' => [ 
                'resource' 
        ] 
] );

/**
 * 自动载入、异常和基础服务
 *
 * @since 2016年11月18日 上午12:49:09
 * @author dyhb
 */
class Q {
    
    /**
     * 是否启用自动载入
     *
     * @var boolean
     */
    private static $bAutoLoad = true;
    
    /**
     * 命名空间映射,具有顺序性
     *
     * @var array
     */
    protected static $arrNamespace = [ ];
    
    /**
     * 命名空间缓存
     *
     * @var string
     */
    const NAMESPACE_CACHE = '.namespace';
    
    /**
     * 系统配置
     *
     * @var array
     */
    private static $arrOption = [ ];
    
    /**
     * 是否开启语言包
     *
     * @var boolean
     */
    public static $booI18nOn = false;
    
    /**
     * 实例对象（实现单一实例）
     *
     * @var array
     */
    private static $arrInstances = [ ];
    
    // ######################################################
    // ------------------- 框架核心功能 start -------------------
    // ######################################################
    
    /**
     * 对象类管理
     */
    static public function app($sAppName = '') {
        return app::getApp ( $sAppName );
    }
    
    /**
     * 自动载入
     * 基于 PSR-4 规范构建
     *
     * @param string $sClassName
     *            当前的类名
     * @return mixed
     */
    static public function autoLoad($sClassName) {
        if (self::$bAutoLoad === false) {
            return;
        }
        
        if ($sClassName {0} == '\\') {
            $sClassName = ltrim ( $sClassName, '\\' );
        }
        
        /**
         * 非命名空间的类
         */
        if (strpos ( $sClassName, '\\' ) === false) {
            $sFile = str_replace ( '_', '\\', $sClassName ) . '.php';
            return self::requireFile ( $sFile );
        } else {
            $sPrefix = $sClassName;
            while ( false !== ($intPos = strrpos ( $sPrefix, '\\' )) ) {
                $sPrefix = substr ( $sClassName, 0, $intPos + 1 );
                
                $sRelativeClass = substr ( $sClassName, $intPos + 1 );
                $sMappedFile = self::loadMappedFile ( $sPrefix, $sRelativeClass );
                
                if ($sMappedFile) {
                    return $sMappedFile;
                }
                
                $sPrefix = rtrim ( $sPrefix, '\\' );
            }
        }
    }
    
    /**
     * 导入一个目录中命名空间结构
     *
     * @param string|array $namespace
     *            命名空间名字
     * @param string $sPackage
     *            命名空间路径
     * @param 支持参数 $in
     *            ignore 忽略扫描目录
     *            force 是否强制更新缓存
     * @return void
     */
    static public function import($namespace, $sPackage, $in = []) {
        $in = array_merge ( [ 
                'ignore' => [ ],
                'force' => false 
        ], $in );
        
        if (! is_dir ( $sPackage )) {
            self::errorMessage ( "Package:'{$sPackage}' does not exists." );
        }
        
        // 包路径
        $sPackagePath = realpath ( $sPackage ) . '/';
        $sCache = $sPackagePath . self::NAMESPACE_CACHE;
        
        if ($in ['force'] === true || ! is_file ( $sCache )) {
            // 扫描命名空间
            $arrPath = self::scanNamespace ( $sPackagePath, '', $in ['ignore'] );
            
            // 写入文件
            if (! file_put_contents ( $sCache, json_encode ( $arrPath ) )) {
                self::errorMessage ( sprintf ( 'Can not create cache file: %s', $sCache ) );
            }
        } else {
            $arrPath = self::readCache ( $sCache );
        }
        
        if (! is_array ( $namespace )) {
            $namespace = [ 
                    $namespace 
            ];
        }
        
        foreach ( $namespace as $sNamespace ) {
            self::addNamespace ( $sNamespace, $sPackage );
            foreach ( $arrPath as $sPath ) {
                self::addNamespace ( $sNamespace . '\\' . $sPath, $sPackage . '/' . $sPath );
            }
        }
    }
    
    /**
     * 添加一个命名空间别名
     *
     * @param string $namespace
     *            命名空间前缀
     * @param mixed:string|array $baseDir
     *            命名空间的对应路径
     * @param array $in
     *            额外参数
     *            bool prepend true 表示插入命名空间前面，优先路径
     * @return void
     */
    public static function addNamespace($sNamespace, $mixBaseDir, $in = []) {
        $in = array_merge ( [ 
                'prepend' => false 
        ], $in );
        
        // 多个目录同时传入
        if (! is_array ( $mixBaseDir )) {
            $mixBaseDir = [ 
                    $mixBaseDir 
            ];
        }
        
        // 导入
        $sNamespace = trim ( $sNamespace, '\\' ) . '\\';
        if (isset ( self::$arrNamespace [$sNamespace] ) === false) {
            self::$arrNamespace [$sNamespace] = [ ];
        }
        
        foreach ( $mixBaseDir as $sBase ) {
            $sBase = rtrim ( $sBase, '/' ) . DIRECTORY_SEPARATOR;
            $sBase = rtrim ( $sBase, DIRECTORY_SEPARATOR ) . '/';
            
            // 优先插入
            if ($in ['prepend'] === true) {
                array_unshift ( self::$arrNamespace [$sNamespace], $sBase );
            } else {
                array_push ( self::$arrNamespace [$sNamespace], $sBase );
            }
        }
    }
    
    /**
     * 设置自动载入是否启用
     *
     * @param bool $bAutoload
     *            true　表示启用
     * @return 旧的设置值
     */
    static public function setAutoload($bAutoload) {
        if (! is_bool ( $bAutoload )) {
            $bAutoload = $bAutoload ? true : false;
        } else {
            $bAutoload = &$bAutoload;
        }
        
        $bOldValue = self::$bAutoLoad;
        self::$bAutoLoad = $bAutoload;
        return $bOldValue;
    }
    
    /**
     * 获取 in 数据
     *
     * @param string $sKey            
     * @param string $sVar            
     * @return 返回数据
     */
    static function in($sKey, $sVar = 'request') {
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
     * 单一实例
     *
     * @param string $sClass            
     * @param mixed $mixArgs            
     * @param string $sMethod            
     * @param mixed $mixMethodArgs            
     */
    static public function instance($sClass, $mixArgs = null, $sMethod = null, $mixMethodArgs = null) {
        $sIdentify = $sClass . serialize ( $mixArgs ) . $sMethod . serialize ( $mixMethodArgs ); // 惟一识别号
        
        if (! isset ( self::$arrInstances [$sIdentify] )) {
            if (class_exists ( $sClass )) {
                $oClass = $mixArgs === null ? new $sClass () : new $sClass ( $mixArgs );
                if (! empty ( $sMethod ) && method_exists ( $oClass, $sMethod )) {
                    self::$arrInstances [$sIdentify] = $mixMethodArgs === null ? call_user_func ( [ 
                            $oClass,
                            $sMethod 
                    ] ) : call_user_func_array ( [ 
                            $oClass,
                            $sMethod 
                    ], is_array ( $mixMethodArgs ) ? $mixMethodArgs : [ 
                            $mixMethodArgs 
                    ] );
                } else {
                    self::$arrInstances [$sIdentify] = $oClass;
                }
            } else {
                self::throwException ( sprintf ( 'class %s is not exists', $sClass ) );
            }
        }
        
        return self::$arrInstances [$sIdentify];
    }
    
    /**
     * 缓存统一入口
     *
     * @param string $sId            
     * @param string $mixData            
     * @param array $arrOption            
     * @param string $sBackendClass            
     * @return boolean
     */
    static public function cache($sId, $mixData = '', array $arrOption = null, $sBackendClass = null) {
        static $oObj = null;
        
        if (! is_array ( $arrOption )) {
            $arrOption = [ ];
        }
        $arrOption = array_merge ( [ 
                'cache_time' => self::cacheTime_ ( $sId ) ?  : $GLOBALS ['option'] ['runtime_cache_time'],
                'cache_prefix' => $GLOBALS ['option'] ['runtime_cache_prefix'],
                'cache_backend' => $GLOBALS ['option'] ['runtime_cache_backend'] 
        ], $arrOption );
        
        if (is_null ( $oObj )) {
            // 强制使用某个缓存引擎
            if (is_null ( $sBackendClass )) {
                $sBackendClass = $arrOption ['cache_backend'];
            }
            $oObj = self::instance ( $sBackendClass );
        }
        
        if ($mixData === '') {
            // 强制刷新页面数据
            if (self::in ( $GLOBALS ['option'] ['runtime_cache_force_name'] ) == 1) {
                return false;
            }
            return $oObj->getCache ( $sId, $arrOption );
        }
        if ($mixData === null) {
            return $oObj->deleleCache ( $sId, $arrOption );
        }
        return $oObj->setCache ( $sId, $mixData, $arrOption );
    }
    
    /**
     * 读取、设置、删除配置值
     *
     * @param string $sName            
     * @param mixed $mixValue            
     * @param mixed $mixDefault            
     * @return mixed
     */
    static public function option($sName = '', $mixValue = NULL, $mixDefault = null) {
        // 返回配置数据
        if (is_string ( $sName ) && ! empty ( $sName ) && $mixValue === null) {
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
        
        // 返回所有配置值
        if ($sName === '' && $mixValue === null) {
            return self::$arrOption;
        }
        
        // 设置值
        if (is_array ( $sName )) {
            foreach ( $sName as $sKey => $mixValue ) {
                self::option ( $sKey, $mixValue, $mixDefault );
            }
            return $GLOBALS ['option'] = self::$arrOption;
        } else {
            if (! strpos ( $sName, '.' )) {
                self::$arrOption [$sName] = $mixValue;
                return $GLOBALS ['option'] = self::$arrOption;
            }
            
            $arrParts = explode ( '.', $sName );
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
            
            return $GLOBALS ['option'] = self::$arrOption;
        }
        
        // 删除值
        if ($sName === null) {
            self::$arrOption = [ ];
        } elseif (! strpos ( $sName, '.' )) {
            unset ( self::$arrOption [$sName] );
        } else {
            $arrParts = explode ( '.', $sName );
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
        
        return $GLOBALS ['option'] = self::$arrOption;
    }
    
    /**
     * 产品国际化支持
     *
     * @param 语言 $sValue            
     * @return mixed
     */
    static public function i18n($sValue/*argvs*/){
        // 不开启
        if (! $GLOBALS ['option'] ['i18n_on'] || ! self::$booI18nOn) {
            if (func_num_args () > 1) { // 代入参数
                $sValue = call_user_func_array ( 'sprintf', func_get_args () );
            }
            return $sValue;
        }
        
        // 返回当地语句
        $sValue = call_user_func_array ( [ 
                'Q\i18n\i18n',
                'getText' 
        ], func_get_args () );
        return $sValue;
    }
    
    /**
     * cookie 统一入口
     *
     * @param string $sName            
     * @param mixed $mixValue            
     * @param number $nLife            
     * @param array $in
     *            cookie_domain 是否启用域名
     *            prefix 是否开启前缀
     *            http_only
     *            only_delete_prefix
     */
    static public function cookie($sName, $mixValue = '', $nLife = 0, array $in = []) {
        $in = array_merge ( [ 
                'cookie_domain' => null,
                'prefix' => true,
                'http_only' => false,
                'only_delete_prefix' => true 
        ], $in );
        
        // 清除指定前缀的所有cookie
        if (is_null ( $sName )) {
            if (empty ( $_COOKIE )) {
                return;
            }
            cookie::clearCookie ( $in ['only_delete_prefix'] );
            return;
        }
        
        // 如果值为null，则删除指定COOKIE
        if ($nLife < 0 || $mixValue === null) {
            cookie::deleteCookie ( $sName, $in ['cookie_domain'], $in ['prefix'] );
        } elseif ($mixValue == '' && $nLife >= 0) { // 如果值为空，则获取cookie
            return cookie::getCookie ( $sName, $in ['prefix'] );
        } else { // 设置COOKIE
            cookie::setCookie ( $sName, $mixValue, $nLife, $in );
        }
    }
    
    /**
     * 返回完整 URL 地址
     *
     * @param string $sDomain            
     * @param string $sHttpPrefix            
     * @param string $sHttpSuffix            
     * @return string
     */
    static public function urlFull($sDomain = '', $sHttpPrefix = '', $sHttpSuffix = '') {
        static $sHttpPrefix = '', $sHttpSuffix = '';
        if (! $sHttpPrefix) {
            $sHttpPrefix = self::isSsl () ? 'https://' : 'http://';
            $sHttpSuffix = $GLOBALS ['option'] ['url_domain_top'] . $GLOBALS ['option'] ['url_domain_suffix'];
        }
        return $sHttpPrefix . ($sDomain && $sDomain != '*' ? $sDomain . '.' : '') . $sHttpSuffix;
    }
    
    /**
     * 生成路由地址
     *
     * @param string $sUrl            
     * @param array $arrParams            
     * @param mixed $mixSuffix            
     * @param boolean $bNormalurl            
     * @return string
     */
    static public function url($sUrl, $arrParams = [], $mixSuffix = true, $bNormalurl = false) {
        // URL支持[var]风格模式替换
        $sUrl = preg_replace_callback ( "/\[([0-9a-zA-Z\_\-\:\.\/]+)\]/", function ($arrMatches) {
            return self::parseUrl_ ( $arrMatches [1] );
        }, $sUrl );
        
        // 剔除受保护的额外参数
        if ($GLOBALS ['option'] ['url_pro_var']) {
            foreach ( explode ( ',', $GLOBALS ['option'] ['url_pro_var'] ) as $sTempVar ) {
                if (isset ( $arrParams [$sTempVar] )) {
                    unset ( $arrParams [$sTempVar] );
                }
            }
        }
        
        // 剥离子域名
        $sDomainUrl = '';
        if (strpos ( $sUrl, '~@' ) !== false) {
            $sUrl = explode ( '~@', $sUrl );
            $sDomainUrl = $sUrl [0];
            $sUrl = $sUrl [1];
        } else {
            $sDomainUrl = false;
        }
        
        // 以“/”开头的为自定义URL
        $bCustom = false;
        if (0 === strpos ( $sUrl, '/' )) {
            $bCustom = true;
        } else {
            if ($sUrl != '') {
                if (! strpos ( $sUrl, '://' )) {
                    $sUrl = APP_NAME . '://' . $sUrl;
                }
                if (stripos ( $sUrl, '@?' )) {
                    $sUrl = str_replace ( '@?', '@QueryPHP?', $sUrl );
                } elseif (stripos ( $sUrl, '@' )) {
                    $sUrl = $sUrl . MODULE_NAME;
                }
                
                // app && 路由
                $arrArray = parse_url ( $sUrl );
            } else {
                $arrArray = [ ];
            }
            
            $sApp = isset ( $arrArray ['scheme'] ) ? $arrArray ['scheme'] : APP_NAME; // APP
            $sRoute = isset ( $arrArray ['user'] ) ? $arrArray ['user'] : ''; // 路由
                                                                              
            // 分析获取模块和操作(应用)
            if (! empty ( $arrParams ['app'] )) {
                $sApp = strtolower ( $arrParams ['app'] );
                unset ( $arrParams ['app'] );
            }
            if (! empty ( $arrParams ['c'] )) {
                $sModule = strtolower ( $arrParams ['c'] );
                unset ( $arrParams ['c'] );
            }
            if (! empty ( $arrParams ['a'] )) {
                $sAction = strtolower ( $arrParams ['a'] );
                unset ( $arrParams ['a'] );
            }
            if (isset ( $arrArray ['path'] )) {
                if (! isset ( $sModule )) {
                    if (! isset ( $arrArray ['host'] )) {
                        $sModule = MODULE_NAME;
                    } else {
                        $sModule = $arrArray ['host'];
                    }
                }
                
                if (! isset ( $sAction )) {
                    $sAction = substr ( $arrArray ['path'], 1 );
                }
            } else {
                if (! isset ( $sModule )) {
                    $sModule = MODULE_NAME;
                }
                if (! isset ( $sAction )) {
                    $sAction = $arrArray ['host'];
                }
            }
            
            // 如果指定了查询参数
            if (isset ( $arrArray ['query'] )) {
                $arrQuery = [ ];
                parse_str ( $arrArray ['query'], $arrQuery );
                $arrParams = array_merge ( $arrQuery, $arrParams );
            }
        }
        
        // 如果开启了URL解析，则URL模式为非普通模式
        if (($GLOBALS ['option'] ['url_model'] > 0 && $bNormalurl === false) || $bCustom === true) {
            $sDepr = '/';
            if (! empty ( $sRoute )) {
                // 匹配路由参数
                if (isset ( $GLOBALS ['option'] ['url_router'] [$sRoute] )) {
                    $arrRouters = $GLOBALS ['option'] ['url_router'] [$sRoute];
                    if (! empty ( $arrRouters [1] )) {
                        $arrRoutervalue = explode ( ',', $arrRouters [1] );
                        foreach ( $arrRoutervalue as $sRoutervalue ) {
                            if (array_key_exists ( $sRoutervalue, $arrParams )) {
                                $sRoute .= $sDepr . urlencode ( $arrParams [$sRoutervalue] );
                                unset ( $arrParams [$sRoutervalue] );
                            }
                        }
                    }
                }
                
                $sStr = $sDepr;
                foreach ( $arrParams as $sVar => $sVal ) {
                    $sStr .= $sVar . $sDepr . urlencode ( $sVal ) . $sDepr;
                }
                $sStr = substr ( $sStr, 0, - 1 );
                
                $sUrl = (__APP__ !== '/' ? __APP__ : '') . ($GLOBALS ['option'] ['default_app'] != $sApp ? '/app' . $sDepr . $sApp . $sDepr : '/') . $sRoute . $sStr;
            } else {
                $sStr = $sDepr;
                foreach ( $arrParams as $sVar => $sVal ) {
                    $sStr .= $sVar . $sDepr . urlencode ( $sVal ) . $sDepr;
                }
                $sStr = substr ( $sStr, 0, - 1 );
                
                if (! $bCustom) {
                    $sUrl = (__APP__ !== '/' ? __APP__ : '') . ($GLOBALS ['option'] ['default_app'] != $sApp ? '/app' . $sDepr . $sApp . $sDepr : '/');
                    
                    if ($sStr) {
                        $sUrl .= $sModule . $sDepr . $sAction . $sStr;
                    } else {
                        $sTemp = '';
                        if ($GLOBALS ['option'] ['default_controller'] != $sModule || $GLOBALS ['option'] ['default_action'] != $sAction) {
                            $sTemp .= $sModule;
                        }
                        if ($GLOBALS ['option'] ['default_action'] != $sAction) {
                            $sTemp .= $sDepr . $sAction;
                        }
                        
                        if ($sTemp == '') {
                            $sUrl = rtrim ( $sUrl, '/' . $sDepr );
                        } else {
                            $sUrl .= $sTemp;
                        }
                    }
                } else {
                    $sUrl .= $sStr;
                }
            }
            
            if ($mixSuffix && $sUrl) {
                $sUrl .= $mixSuffix === true ? $GLOBALS ['option'] ['url_html_suffix'] : $mixSuffix;
            }
        } else {
            $sStr = '';
            foreach ( $arrParams as $sVar => $sVal ) {
                $sStr .= $sVar . '=' . urlencode ( $sVal ) . '&';
            }
            $sStr = rtrim ( $sStr, '&' );
            
            if (empty ( $sRoute )) {
                $sTemp = '';
                if ($bNormalurl === true || $GLOBALS ['option'] ['default_app'] != $sApp) {
                    $sTemp [] = 'app=' . $sApp;
                }
                if ($GLOBALS ['option'] ['default_controller'] != $sModule) {
                    $sTemp [] = 'c=' . $sModule;
                }
                if ($GLOBALS ['option'] ['default_action'] != $sAction) {
                    $sTemp [] = 'a=' . $sAction;
                }
                if ($sStr) {
                    $sTemp [] = $sStr;
                }
                if (! empty ( $sTemp )) {
                    $sTemp = '?' . implode ( '&', $sTemp );
                }
                $sUrl = ($bNormalurl === true || __APP__ !== '/' ? __APP__ : '') . $sTemp;
            } else {
                $sUrl = ($bNormalurl === true || __APP__ !== '/' ? __APP__ : '') . ($bNormalurl === true || $GLOBALS ['option'] ['default_app'] != $sApp ? '?app=' . $sApp . '&' : '?') . ($sRoute ? 'r=' . $sRoute : '') . ($sStr ? '&' . $sStr : '');
            }
        }
        
        // 子域名支持
        if ($GLOBALS ['option'] ['url_subdomain_on'] === true) {
            if ($sDomainUrl === false) {
                $sDomainUrl = 'www';
            } elseif ($sDomainUrl == '') {
                $sDomainUrl = '*';
            } elseif ($sDomainUrl == '*') {
                $sDomainUrl = '';
            }
            if ($sDomainUrl) {
                $sDomainUrl = self::urlFull ( $sDomainUrl );
            }
        } elseif ($GLOBALS ['option'] ['url_domain_on'] === true) { // URL加上域名
            $sDomainUrl = $GLOBALS ['option'] ['url_domain'];
        } else {
            $sDomainUrl = '';
        }
        $sUrl = $sDomainUrl . $sUrl;
        
        return $sUrl;
    }
    
    /**
     * 行为插件 todo
     *
     * @param string $sTag            
     */
    static public function tag($sTag) {
        if (array_key_exists ( $sTag, $GLOBALS ['option'] ['globals_tags'] )) {
            if (is_array ( $GLOBALS ['option'] ['globals_tags'] [$sTag] )) {
                $arrOption = $GLOBALS ['option'] ['globals_tags'] [$sTag];
            } else {
                $arrOption = [ 
                        $GLOBALS ['option'] ['globals_tags'] [$sTag],
                        [ ] 
                ];
            }
            
            $sTag = ucfirst ( $arrOption [0] ) . '_Behavior';
            if (self::classExists ( $sTag )) {
                $oBehavior = new $sTag ();
                $oBehavior->RUN ( $arrOption [1] );
            }
        }
    }
    
    /**
     * 调试工具
     *
     * @param mixed $Var            
     * @param boolean $bEcho            
     * @param string $sLabel            
     * @param boolean $bStrict            
     * @return
     *
     */
    static public function dump($mixVar, $bEcho = true, $sLabel = null, $bStrict = true) {
        $SLabel = ($sLabel === null) ? '' : rtrim ( $sLabel ) . ' ';
        if (! $bStrict) {
            if (ini_get ( 'html_errors' )) {
                $sOutput = print_r ( $mixVar, true );
                $sOutput = "<pre>" . $sLabel . htmlspecialchars ( $sOutput, ENT_QUOTES ) . "</pre>";
            } else {
                $sOutput = $sLabel . " : " . print_r ( $mixVar, true );
            }
        } else {
            ob_start ();
            var_dump ( $mixVar );
            $sOutput = ob_get_clean ();
            if (! extension_loaded ( 'xdebug' )) {
                $sOutput = preg_replace ( "/\]\=\>\n(\s+)/m", "] => ", $sOutput );
                $sOutput = '<pre>' . $sLabel . htmlspecialchars ( $sOutput, ENT_QUOTES ) . '</pre>';
            }
        }
        
        if ($bEcho) {
            echo $sOutput;
            return null;
        } else {
            return $sOutput;
        }
    }
    
    // ######################################################
    // ------------------- 框架核心功能 end -------------------
    // ######################################################
    
    // ######################################################
    // ------------------- 错误异常相关 start -------------------
    // ######################################################
    
    /**
     * 接管 PHP 异常
     *
     * @param Exception $oE            
     */
    static public function exceptionHandler(Exception $oE) {
        $sErrstr = $oE->getMessage ();
        $sErrfile = $oE->getFile ();
        $nErrline = $oE->getLine ();
        $nErrno = $oE->getCode ();
        $sErrorStr = "[$nErrno] $sErrstr " . basename ( $sErrfile ) . Q::i18n ( " 第 %d 行", $nErrline );
        
        if ($GLOBALS ['option'] ['log_record'] && self::option ( 'log_must_record_exception' )) {
            Log::W ( $sErrstr, Log::EXCEPTION );
        }
        
        if (method_exists ( $oE, 'formatException' )) {
            self::halt ( $oE->formatException (), $oE instanceof DbException );
        } else {
            self::halt ( $oE->getMessage (), $oE instanceof DbException );
        }
    }
    
    /**
     * 接管 PHP 错误
     *
     * @param int $nErrorNo            
     * @param string $sErrStr            
     * @param string $sErrFile            
     * @param int $nErrLine            
     */
    static public function errorHandel($nErrorNo, $sErrStr, $sErrFile, $nErrLine) {
        if ($nErrorNo) {
            self::errorMessage ( "[{$nErrorNo}]: {$sErrStr}<br> File: {$sErrFile}<br> Line: {$nErrLine}" );
        }
    }
    
    /**
     * 接管 PHP 致命错误
     */
    static public function shutdownHandel() {
        if (($arrError = error_get_last ()) && ! empty ( $arrError ['type'] )) {
            self::errorMessage ( "[{$arrError['type']}]: {$arrError['message']} <br> File: {$arrError['file']} <br> Line: {$arrError['line']}" );
        }
    }
    
    /**
     * 抛出异常
     *
     * @param string $sMsg            
     * @param string $sType            
     * @param number $nCode            
     */
    static public function throwException($sMsg, $sType = 'QException', $nCode = 0) {
        if (self::classExists ( $sType )) {
            throw new $sType ( $sMsg, $nCode );
        } else {
            self::halt ( $sMsg ); // 异常类型不存在则输出错误信息字串
        }
    }
    
    /**
     * 输入错误异常消息
     *
     * @param mixed $mixError            
     * @param boolean $bDbError            
     */
    static public function halt($mixError, $bDbError = FALSE) {
        if (! is_array ( $mixError )) {
            $arrTemp ['message'] = $mixError;
            $mixError = $arrTemp;
            unset ( $arrTemp );
        }
        
        // 否则定向到错误页面
        if (! empty ( $GLOBALS ['option'] ['show_exception_redirect'] ) && $bDbError === FALSE && Q_DEBUG === FALSE) {
            self::urlRedirect ( self::url ( $GLOBALS ['option'] ['show_exception_redirect'] ) );
        } else {
            if ($GLOBALS ['option'] ['show_exception_show_message'] === false) {
                $mixError ['message'] = $GLOBALS ['option'] ['show_exception_default_message'];
            }
            
            // 包含异常页面模板
            if ($GLOBALS ['option'] ['show_exception_tpl'] && is_file ( $GLOBALS ['option'] ['show_exception_tpl'] )) {
                include ($GLOBALS ['option'] ['show_exception_tpl']);
            } else {
                include (Q_PATH . '/resource/tpl/exception.php');
            }
        }
        
        exit ();
    }
    
    /**
     * 输出一个致命错误
     *
     * @param string $sMessage            
     */
    static public function errorMessage($sMessage) {
        require_once (Q_PATH . '/resource/tpl/error.php');
        exit ();
    }
    
    // ######################################################
    // ------------------ - 错误异常相关 end ------ -------------
    // ######################################################
    
    // ######################################################
    // ------------------- 数据类型检查 start -------------------
    // ######################################################
    
    /**
     * 验证 PHP 各种变量类型
     *
     * @param 待验证的变量 $mixVar            
     * @param string $sType
     *            变量类型
     * @return boolean
     */
    static public function varType($mixVar, $sType) {
        $sType = trim ( $sType ); // 整理参数，以支持 array:ini 格式
        $sType = explode ( ':', $sType );
        $sType [0] = strtolower ( $sType [0] );
        
        switch ($sType [0]) {
            case 'string' : // 字符串
                return is_string ( $mixVar );
            case 'integer' : // 整数
            case 'int' :
                return is_int ( $mixVar );
            case 'float' : // 浮点
                return is_float ( $mixVar );
            case 'boolean' : // 布尔
            case 'bool' :
                return is_bool ( $mixVar );
            case 'num' : // 数字
            case 'numeric' :
                return is_numeric ( $mixVar );
            case 'base' : // 标量（所有基础类型）
            case 'scalar' :
                return is_scalar ( $mixVar );
            case 'handle' : // 外部资源
            case 'resource' :
                return is_resource ( $mixVar );
            case 'array' :
                { // 数组
                    if (! empty ( $sType [1] )) {
                        $sType [1] = explode ( ',', $sType [1] );
                        return self::checkArray ( $mixVar, $sType [1] );
                    } else {
                        return is_array ( $mixVar );
                    }
                }
            case 'object' : // 对象
                return is_object ( $mixVar );
            case 'null' : // 空
                return ($mixVar === null);
            case 'callback' : // 回调函数
                return is_callable ( $mixVar, false );
            default : // 类
                return self::isKindOf ( $mixVar, implode ( ':', $sType ) );
        }
    }
    
    /**
     * 验证是否为同一回调
     *
     * @param callback $calA            
     * @param callback $calkB            
     * @return boolean
     */
    static public function isSameCallback($calA, $calB) {
        if (! is_callable ( $calA ) || is_callable ( $calB )) {
            return false;
        }
        
        if (is_array ( $calA )) {
            if (is_array ( $calB )) {
                return ($calA [0] === $calB [0]) and (strtolower ( $calA [1] ) === strtolower ( $calB [1] ));
            } else {
                return false;
            }
        } else {
            return strtolower ( $calA ) === strtolower ( $calB );
        }
    }
    
    /**
     * 验证参数是否为指定的类型集合
     *
     * @param mixed $mixVar            
     * @param mixed $mixTypes            
     * @return boolean
     */
    static public function isThese($mixVar, $mixTypes) {
        if (! self::varType ( $mixTypes, 'string' ) && ! self::checkArray ( $mixTypes, [ 
                'string' 
        ] )) {
            self::throwException ( Q::i18n ( '正确格式:参数必须为 string 或 各项元素为 string 的数组' ) );
        }
        
        if (is_string ( $mixTypes )) {
            $mixTypes = [ 
                    $mixTypes 
            ];
        }
        
        foreach ( $mixTypes as $sType ) { // 类型检查
            if (self::varType ( $mixVar, $sType )) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * 检查一个对象实例或者类名是否继承至接口或者类
     *
     * @param mixed $mixSubClass            
     * @param string $sBaseClass            
     * @return boolean
     */
    static public function isKindOf($mixSubClass, $sBaseClass) {
        if (self::classExists ( $sBaseClass, true )) { // 接口
            return self::isImplementedTo ( $mixSubClass, $sBaseClass );
        } else { // 类
            if (is_object ( $mixSubClass )) { // 统一类名,如果不是，返回false
                $mixSubClass = get_class ( $mixSubClass );
            } elseif (! is_string ( $mixSubClass )) {
                return false;
            }
            
            if ($mixSubClass == $sBaseClass) { // 子类名 即为父类名
                return true;
            }
            
            $sParClass = get_parent_class ( $mixSubClass ); // 递归检查
            if (! $sParClass) {
                return false;
            }
            
            return self::isKindOf ( $sParClass, $sBaseClass );
        }
    }
    
    /**
     * 检查对象实例或者类名 是否继承至接口
     *
     * @param mixed $mixClass            
     * @param string $sInterface            
     * @param string $bStrictly            
     * @return boolean
     */
    static public function isImplementedTo($mixClass, $sInterface, $bStrictly = false) {
        if (is_object ( $mixClass )) { // 尝试获取类名，否则返回false
            $mixClass = get_class ( $mixClass );
            if (! is_string ( $mixClass )) { // 类型检查
                return false;
            }
        } elseif (! is_string ( $Class )) {
            return false;
        }
        
        if (! class_exists ( $mixClass ) || ! interface_exists ( $sInterface )) { // 检查类和接口是否都有效
            return false;
        }
        
        // 建立反射
        $oReflectionClass = new ReflectionClass ( $sClassName );
        $arrInterfaceRefs = $oReflectionClass->getInterfaces ();
        foreach ( $arrInterfaceRefs as $oInterfaceRef ) {
            if ($oInterfaceRef->getName () != $sInterface) {
                continue;
            }
            
            if (! $bStrictly) { // 找到 匹配的 接口
                return true;
            }
            
            // 依次检查接口中的每个方法是否实现
            $arrInterfaceFuncs = get_class_methods ( $sInterface );
            foreach ( $arrInterfaceFuncs as $sFuncName ) {
                $sReflectionMethod = $oReflectionClass->getMethod ( $sFuncName );
                if ($sReflectionMethod->isAbstract ()) { // 发现尚为抽象的方法
                    return false;
                }
            }
            
            return true;
        }
        
        // 递归检查父类
        if (($sParName = get_parent_class ( $sClassName )) !== false) {
            return self::isImplementedTo ( $sParName, $sInterface, $bStrictly );
        } else {
            return false;
        }
    }
    
    /**
     * 验证类是否存在
     *
     * @param string $sClassName            
     * @param boolean $bInter            
     * @param boolean $bAutoload            
     * @return boolean
     */
    static public function classExists($sClassName, $bInter = false, $bAutoload = false) {
        $bAutoloadOld = self::setAutoload ( $bAutoload );
        $sFuncName = $bInter ? 'interface_exists' : 'class_exists';
        $bResult = $sFuncName ( $sClassName );
        self::setAutoload ( $bAutoloadOld );
        return $bResult;
    }
    
    /**
     * 验证数组中的每一项格式化是否正确
     *
     * @param array $arrArray            
     * @param array $arrTypes            
     * @return boolean
     */
    static public function checkArray($arrArray, array $arrTypes) {
        if (! is_array ( $arrArray )) { // 不是数组直接返回
            return false;
        }
        
        // 判断数组内部每一个值是否为给定的类型
        foreach ( $arrArray as &$mixValue ) {
            $bRet = false;
            foreach ( $arrTypes as $mixType ) {
                if (self::varType ( $mixValue, $mixType )) {
                    $bRet = true;
                    break;
                }
            }
            
            if (! $bRet) {
                return false;
            }
        }
        
        return true;
    }
    
    /**
     * 验证类是否有静态方法
     *
     * @param string $sClassName            
     * @param string $sMethodName            
     * @return boolean
     */
    public static function hasStaticMethod($sClassName, $sMethodName) {
        $oRef = new ReflectionClass ( $sClassName );
        if ($oRef->hasMethod ( $sMethodName ) and $oRef->getMethod ( $sMethodName )->isStatic ()) {
            return true;
        }
        return false;
    }
    
    /**
     * 验证对象实例是否有 public 方法
     *
     * @param object $objClass            
     * @param string $sMethodName            
     * @return boolean
     */
    public static function hasPublicMethod($objClass, $sMethodName) {
        $objClass = new \ReflectionMethod ( $objClass, $sMethodName );
        if ($objClass->isPublic () and ! $objClass->isStatic ()) {
            return $objClass;
        }
        return false;
    }
    
    /**
     * 验证数组是否为一维
     *
     * @param array $arrArray            
     * @return boolean
     */
    static public function oneImensionArray($arrArray) {
        return count ( $arrArray ) == count ( $arrArray, 1 );
    }
    
    // ######################################################
    // -------------------- 数据类型检查 end --------------------
    // ######################################################
    
    // ######################################################
    // ------------------- 常用辅助方法 start ------ ------------
    // ######################################################
    
    /**
     * 整理目录斜线风格
     *
     * @param string $sPath            
     * @param boolean $bUnix            
     * @return string
     */
    static public function tidyPath($sPath, $bUnix = true) {
        $sRetPath = str_replace ( '\\', '/', $sPath ); // 统一 斜线方向
        $sRetPath = preg_replace ( '|/+|', '/', $sRetPath ); // 归并连续斜线
        
        $arrDirs = explode ( '/', $sRetPath ); // 削除 .. 和 .
        $arrDirsTemp = [ ];
        while ( ($sDirName = array_shift ( $arrDirs )) !== null ) {
            if ($sDirName == '.') {
                continue;
            }
            
            if ($sDirName == '..') {
                if (count ( $arrDirsTemp )) {
                    array_pop ( $arrDirsTemp );
                    continue;
                }
            }
            
            array_push ( $arrDirsTemp, $sDirName );
        }
        
        $sRetPath = implode ( '/', $arrDirsTemp ); // 目录 以 '/' 结尾
        if (@is_dir ( $sRetPath )) { // 存在的目录
            if (! preg_match ( '|/$|', $sRetPath )) {
                $sRetPath .= '/';
            }
        } else if (preg_match ( "|\.$|", $sPath )) { // 不存在，但是符合目录的格式
            if (! preg_match ( '|/$|', $sRetPath )) {
                $sRetPath .= '/';
            }
        }
        
        $sRetPath = str_replace ( ':/', ':\\', $sRetPath ); // 还原 驱动器符号
        if (! $bUnix) { // 转换到 Windows 斜线风格
            $sRetPath = str_replace ( '/', '\\', $sRetPath );
        }
        
        $sRetPath = rtrim ( $sRetPath, '\\/' ); // 删除结尾的“/”或者“\”
        
        return $sRetPath;
    }
    
    /**
     * 创建目录
     *
     * @param string $sDir            
     * @param number $nMode            
     * @return boolean
     */
    static public function makeDir($sDir, $nMode = 0777) {
        if (is_dir ( $sDir )) {
            return true;
        }
        
        if (is_string ( $sDir )) {
            $sDir = explode ( '/', str_replace ( '\\', '/', trim ( $sDir, '/' ) ) );
        }
        
        $sCurDir = self::isWin () ? '' : '/';
        foreach ( $sDir as $nKey => $sTemp ) {
            $sCurDir .= $sTemp . '/';
            if (! is_dir ( $sCurDir )) {
                if (isset ( $sDir [$nKey + 1] ) && is_dir ( $sCurDir . $sDir [$nKey + 1] )) {
                    continue;
                }
                @mkdir ( $sCurDir, $nMode );
            }
        }
        
        return TRUE;
    }
    
    /**
     * 只读取一级目录
     *
     * @param 目录 $sDir            
     * @param array $arrIn
     *            fullpath 是否返回全部路径
     *            returndir 返回目录
     * @return
     *
     */
    static public function listDir($sDir, $arrIn = []) {
        $arrIn = array_merge ( [ 
                'fullpath' => FALSE,
                'return' => 'dir', // file dir both
                'filterdir' => [ 
                        '.',
                        '..',
                        '.svn',
                        '.git',
                        'node_modules' 
                ],
                'filterext' => [ ] 
        ], $arrIn );
        $arrReturnData = [ 
                'file' => [ ],
                'dir' => [ ] 
        ];
        if (is_dir ( $sDir )) {
            $arrFiles = [ ];
            $hDir = opendir ( $sDir );
            while ( ($sFile = readdir ( $hDir )) !== FALSE ) {
                if (in_array ( $sFile, $arrIn ['filterdir'] )) {
                    continue;
                }
                if (is_dir ( $sDir . "/" . $sFile ) && in_array ( $arrIn ['return'], [ 
                        'dir',
                        'both' 
                ] )) {
                    $arrReturnData ['dir'] [] = ($arrIn ['fullpath'] ? $sDir . "/" : '') . $sFile;
                }
                if (is_file ( $sDir . "/" . $sFile ) && in_array ( $arrIn ['return'], [ 
                        'file',
                        'both' 
                ] ) && (! $arrIn ['filterext'] ? true : (in_array ( self::getExtName ( $sFile, 2 ), $arrIn ['filterext'] ) ? false : true))) {
                    $arrReturnData ['file'] [] = ($arrIn ['fullpath'] ? $sDir . "/" : '') . $sFile;
                }
            }
            closedir ( $hDir );
            
            if ($arrIn ['return'] == 'file') {
                return $arrReturnData ['file'];
            } elseif ($arrIn ['return'] == 'dir') {
                return $arrReturnData ['dir'];
            } else {
                return $arrReturnData;
            }
        } else {
            return [ ];
        }
    }
    
    /**
     * 获取上传文件扩展名
     *
     * @param 文件名 $sFileName            
     * @param number $nCase
     *            格式化参数 0 默认，1 转为大小 ，转为大小
     * @return string
     */
    static public function getExtName($sFileName, $nCase = 0) {
        if (! preg_match ( '/\./', $sFileName )) {
            return '';
        }
        
        $sFileName = explode ( '.', $sFileName );
        $sFileName = end ( $sFileName );
        
        if ($nCase == 1) {
            return strtoupper ( $sFileName );
        } elseif ($nCase == 2) {
            return strtolower ( $sFileName );
        } else {
            return $sFileName;
        }
    }
    
    /**
     * 获取 IP 地址
     *
     * @return
     *
     */
    static public function getIp() {
        static $sRealip = NULL;
        
        if ($sRealip !== NULL) {
            return $sRealip;
        }
        
        if (isset ( $_SERVER )) {
            if (isset ( $_SERVER ['HTTP_X_FORWARDED_FOR'] )) {
                $arrValue = explode ( ',', $_SERVER ['HTTP_X_FORWARDED_FOR'] );
                foreach ( $arrValue as $sIp ) { // 取X-Forwarded-For中第一个非unknown的有效IP字符串
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
     * URL 重定向
     *
     * @param string $sUrl            
     * @param number $nTime            
     * @param string $sMsg       
     */
    static public function urlRedirect($sUrl, $nTime = 0, $sMsg = '') {
        $sUrl = str_replace ( [ 
                "\n",
                "\r" 
        ], '', $sUrl ); // 多行URL地址支持
        if (empty ( $sMsg )) {
            $sMsg = 'Please wait for a while...';
        }
        
        if (! headers_sent ()) {
            if (0 == $nTime) {
                header ( "Location:" . $sUrl );
            } else {
                header ( "refresh:{$nTime};url={$sUrl}" );
                include (Q_PATH . '/resource/tpl/url.php'); // 包含跳转页面模板
            }
            exit ();
        } else {
            $sHeader = "<meta http-equiv='Refresh' content='{$nTime};URL={$sUrl}'>";
            if ($nTime == 0) {
                $sHeader = '';
            }
            include (Q_PATH . '/resource/tpl/url.php'); // 包含跳转页面模板
            exit ();
        }
    }
    
    /**
     * 日期格式化
     *
     * @param int $nDateTemp            
     * @param string $sDateFormat            
     * @return string
     */
    static public function formatDate($nDateTemp, $sDateFormat = 'Y-m-d H:i') {
        $sReturn = '';
        
        $nSec = time () - $nDateTemp;
        $nHover = floor ( $nSec / 3600 );
        if ($nHover == 0) {
            $nMin = floor ( $nSec / 60 );
            if ($nMin == 0) {
                $sReturn = $nSec . ' ' . Q::i18n ( "秒前" );
            } else {
                $sReturn = $nMin . ' ' . Q::i18n ( "分钟前" );
            }
        } elseif ($nHover < 24) {
            $sReturn = Q::i18n ( "大约 %d 小时前", $nHover );
        } else {
            $sReturn = date ( $sDateFormat, $nDateTemp );
        }
        
        return $sReturn;
    }
    
    /**
     * 文件大小格式化
     *
     * @param int $nFileSize            
     * @param boolean $booUnit            
     * @return
     *
     */
    static public function formatBytes($nFileSize, $booUnit = true) {
        if ($nFileSize >= 1073741824) {
            $nFileSize = round ( $nFileSize / 1073741824, 2 ) . ($booUnit ? 'GB' : '');
        } elseif ($nFileSize >= 1048576) {
            $nFileSize = round ( $nFileSize / 1048576, 2 ) . ($booUnit ? 'MB' : '');
        } elseif ($nFileSize >= 1024) {
            $nFileSize = round ( $nFileSize / 1024, 2 ) . ($booUnit ? 'KB' : '');
        } else {
            $nFileSize = $nFileSize . ($booUnit ? Q::i18n ( '字节' ) : '');
        }
        
        return $nFileSize;
    }
    
    /**
     * 数组数据格式化
     *
     * @param mixed $mixInput            
     * @param string $sDelimiter            
     * @param boolean $bAllowedEmpty            
     * @return
     *
     */
    public static function normalize($mixInput, $sDelimiter = ',', $bAllowedEmpty = false) {
        if (is_array ( $mixInput ) || is_string ( $mixInput )) {
            if (! is_array ( $mixInput )) {
                $mixInput = explode ( $sDelimiter, $mixInput );
            }
            
            $mixInput = array_filter ( $mixInput ); // 过滤null
            if ($bAllowedEmpty === true) {
                return $mixInput;
            } else {
                $mixInput = array_map ( 'trim', $mixInput );
                return array_filter ( $mixInput, 'strlen' );
            }
        } else {
            return $mixInput;
        }
    }
    
    /**
     * 随机字符串
     *
     * @param int $nLength            
     * @param string $sCharBox            
     * @param boolean $bNumeric            
     * @return
     *
     */
    static public function randString($nLength, $sCharBox = null, $bNumeric = false) {
        if ($bNumeric === true) {
            return sprintf ( '%0' . $nLength . 'd', mt_rand ( 1, pow ( 10, $nLength ) - 1 ) );
        }
        
        if ($sCharBox === null) {
            list ( $nMS, $nS ) = explode ( ' ', microtime () );
            $nCurTime = $nS + $nMS;
            
            $sCharBox = strtoupper ( md5 ( $nCurTime . rand ( 1000000000, 9999999999 ) ) );
            $sCharBox .= md5 ( $nCurTime . rand ( 1000000000, 9999999999 ) );
        }
        
        $nBoxEnd = strlen ( $sCharBox ) - 1;
        $sRet = '';
        while ( $nLength -- ) {
            $sRet .= substr ( $sCharBox, rand ( 0, $nBoxEnd ), 1 );
        }
        
        return $sRet;
    }
    
    /**
     * 字符串编码转换
     *
     * @param mixed $mixContents            
     * @param string $sFromChar            
     * @param string $sToChar            
     * @return
     *
     */
    static public function stringEncoding($mixContents, $sFromChar, $sToChar = 'utf-8') {
        if (empty ( $mixContents )) {
            return $mixContents;
        }
        
        $sFromChar = strtolower ( $sFromChar ) == 'utf8' ? 'utf-8' : strtolower ( $sFromChar );
        $sToChar = strtolower ( $sToChar ) == 'utf8' ? 'utf-8' : strtolower ( $sToChar );
        if ($sFromChar == $sToChar || (is_scalar ( $mixContents ) && ! is_string ( $mixContents ))) {
            return $mixContents;
        }
        
        if (is_string ( $mixContents )) {
            if (function_exists ( 'iconv' )) {
                return iconv ( $sFromChar, $sToChar . '//IGNORE', $mixContents );
            } elseif (function_exists ( 'mb_convert_encoding' )) {
                return mb_convert_encoding ( $mixContents, $sToChar, $sFromChar );
            } else {
                return $mixContents;
            }
        } elseif (is_array ( $mixContents )) {
            foreach ( $mixContents as $sKey => $sVal ) {
                $sKeyTwo = self::gbkToUtf8 ( $sKey, $sFromChar, $sToChar );
                $mixContents [$sKeyTwo] = self::stringEncoding ( $sVal, $sFromChar, $sToChar );
                if ($sKey != $sKeyTwo) {
                    unset ( $mixContents [$sKeyTwo] );
                }
            }
            return $mixContents;
        } else {
            return $mixContents;
        }
    }
    
    /**
     * 判断字符串是否为 UTF8
     *
     * @param string $sString            
     * @return boolean
     */
    public static function isUtf8($sString) {
        $nLength = strlen ( $sString );
        
        for($nI = 0; $nI < $nLength; $nI ++) {
            if (ord ( $sString [$nI] ) < 0x80) {
                $nN = 0;
            } elseif ((ord ( $sString [$nI] ) & 0xE0) == 0xC0) {
                $nN = 1;
            } elseif ((ord ( $sString [$nI] ) & 0xF0) == 0xE0) {
                $nN = 2;
            } elseif ((ord ( $sString [$nI] ) & 0xF0) == 0xF0) {
                $nN = 3;
            } else {
                return FALSE;
            }
            
            for($nJ = 0; $nJ < $nN; $nJ ++) {
                if ((++ $nI == $nLength) || ((ord ( $sString [$nI] ) & 0xC0) != 0x80)) {
                    return FALSE;
                }
            }
        }
        
        return TRUE;
    }
    
    /**
     * 字符串截取
     *
     * @param string $sStr            
     * @param number $nStart            
     * @param number $nLength            
     * @param string $sCharset            
     * @param boolean $bSuffix            
     * @return string
     */
    static public function subString($sStr, $nStart = 0, $nLength = 255, $sCharset = "utf-8", $bSuffix = true) {
        // 对系统的字符串函数进行判断
        if (function_exists ( "mb_substr" )) {
            return mb_substr ( $sStr, $nStart, $nLength, $sCharset );
        } elseif (function_exists ( 'iconv_substr' )) {
            return iconv_substr ( $sStr, $nStart, $nLength, $sCharset );
        }
        
        // 常用几种字符串正则表达式
        $arrRe ['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $arrRe ['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $arrRe ['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $arrRe ['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        
        // 匹配
        preg_match_all ( $arrRe [$sCharset], $sStr, $arrMatch );
        $sSlice = join ( "", array_slice ( $arrMatch [0], $nStart, $nLength ) );
        
        if ($bSuffix) {
            return $sSlice . "…";
        }
        
        return $sSlice;
    }
    
    // ######################################################
    // -------------------- 常用辅助方法 end ------- ------------
    // ######################################################
    
    // ######################################################
    // ------------------- 系统安全相关 start ------ ------------
    // ######################################################
    
    /**
     * 魔术转移处理
     */
    static public function stripslashesMagicquotegpc() {
        if (self::getMagicQuotesGpc ()) {
            $_GET = self::stripslashes ( $_GET );
            $_POST = self::stripslashes ( $_POST );
            $_COOKIE = self::stripslashes ( $_COOKIE );
            $_REQUEST = self::stripslashes ( $_REQUEST );
        }
    }
    
    /**
     * 移除魔术方法转义
     *
     * @param mixed $mixString            
     * @param boolean $bRecursive            
     * @return
     *
     */
    static public function stripslashes($mixString, $bRecursive = true) {
        if ($bRecursive === true and is_array ( $mixString )) { // 递归
            foreach ( $mixString as $sKey => $mixValue ) {
                $mixString [self::stripslashes ( $sKey )] = self::stripslashes ( $mixValue ); // 如果你只注意到值，却没有注意到key
            }
        } else {
            if (is_string ( $mixString )) {
                $mixString = stripslashes ( $mixString );
            }
        }
        
        return $mixString;
    }
    
    /**
     * 添加模式转义
     *
     * @param mixed $mixString            
     * @param string $bRecursive            
     * @return string
     */
    static public function addslashes($mixString, $bRecursive = true) {
        if ($bRecursive === true and is_array ( $mixString )) {
            foreach ( $mixString as $sKey => $mixValue ) {
                $mixString [self::addslashes ( $sKey )] = self::addslashes ( $mixValue ); // 如果你只注意到值，却没有注意到key
            }
        } else {
            if (is_string ( $mixString )) {
                $mixString = addslashes ( $mixString );
            }
        }
        
        return $mixString;
    }
    
    /**
     * 取得当前模式转义状态
     *
     * @return boolean
     */
    static public function getMagicQuotesGpc() {
        if (version_compare ( PHP_VERSION, '5.4.0', '<' )) {
            return get_magic_quotes_gpc () ? TRUE : FALSE;
        } else {
            return FALSE;
        }
    }
    
    /**
     * 来自 Discuz 经典 PHP 加密算法
     *
     * @param string $string            
     * @param boolean $operation            
     * @param string $key            
     * @param number $expiry            
     * @return string
     */
    static public function authcode($string, $operation = TRUE, $key = null, $expiry = 0) {
        $ckey_length = 4;
        
        $key = md5 ( $key ? $key : $GLOBALS ['option'] ['q_auth_key'] );
        $keya = md5 ( substr ( $key, 0, 16 ) );
        $keyb = md5 ( substr ( $key, 16, 16 ) );
        $keyc = $ckey_length ? ($operation === TRUE ? substr ( $string, 0, $ckey_length ) : substr ( md5 ( microtime () ), - $ckey_length )) : '';
        
        $cryptkey = $keya . md5 ( $keya . $keyc );
        $key_length = strlen ( $cryptkey );
        $string = $operation === TRUE ? base64_decode ( substr ( $string, $ckey_length ) ) : sprintf ( '%010d', $expiry ? $expiry + time () : 0 ) . substr ( md5 ( $string . $keyb ), 0, 16 ) . $string;
        $string_length = strlen ( $string );
        
        $result = '';
        $box = range ( 0, 255 );
        $rndkey = [ ];
        for($i = 0; $i <= 255; $i ++) {
            $rndkey [$i] = ord ( $cryptkey [$i % $key_length] );
        }
        
        for($j = $i = 0; $i < 256; $i ++) {
            $j = ($j + $box [$i] + $rndkey [$i]) % 256;
            $tmp = $box [$i];
            $box [$i] = $box [$j];
            $box [$j] = $tmp;
        }
        
        for($a = $j = $i = 0; $i < $string_length; $i ++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box [$a]) % 256;
            $tmp = $box [$a];
            $box [$a] = $box [$j];
            $box [$j] = $tmp;
            $result .= chr ( ord ( $string [$i] ) ^ ($box [($box [$a] + $box [$j]) % 256]) );
        }
        
        if ($operation === TRUE) {
            if ((substr ( $result, 0, 10 ) == 0 || substr ( $result, 0, 10 ) - time () > 0) && substr ( $result, 10, 16 ) == substr ( md5 ( substr ( $result, 26 ) . $keyb ), 0, 16 )) {
                return substr ( $result, 26 );
            } else {
                return '';
            }
        } else {
            return $keyc . str_replace ( '=', '', base64_encode ( $result ) );
        }
    }
    
    /**
     * 正则属性转义
     *
     * @param string $sTxt            
     * @param bool $bEsc            
     * @return
     *
     */
    static public function escapeCharacter($sTxt, $bEsc = true) {
        if ($sTxt == '""') {
            $sTxt = '';
        }
        
        if ($bEsc) { // 转义
            $sTxt = str_replace ( [ 
                    '\\\\',
                    "\\'",
                    '\\"',
                    '\\$',
                    '\\.' 
            ], [ 
                    '\\',
                    '~~{#!`!#}~~',
                    '~~{#!``!#}~~',
                    '~~{#!S!#}~~',
                    '~~{#!dot!#}~~' 
            ], $sTxt );
        } else { // 还原
            $sTxt = str_replace ( [ 
                    '.',
                    "~~{#!`!#}~~",
                    '~~{#!``!#}~~',
                    '~~{#!S!#}~~',
                    '~~{#!dot!#}~~' 
            ], [ 
                    '->',
                    "'",
                    '"',
                    '$',
                    '.' 
            ], $sTxt );
        }
        
        return $sTxt;
    }
    
    /**
     * 过滤掉 javascript
     *
     * @param string $sText
     *            待过滤的字符串
     * @return string
     */
    static public function cleanJs($sText) {
        $sText = trim ( $sText );
        $sText = stripslashes ( $sText );
        $sText = preg_replace ( '/<!--?.*-->/', '', $sText ); // 完全过滤注释
        $sText = preg_replace ( '/<\?|\?>/', '', $sText ); // 完全过滤动态代码
        $sText = preg_replace ( '/<script?.*\/script>/', '', $sText ); // 完全过滤js
        $sText = preg_replace ( '/<\/?(html|head|meta|link|base|body|title|style|script|form|iframe|frame|frameset)[^><]*>/i', '', $sText ); // 过滤多余html
        while ( preg_match ( '/(<[^><]+)(lang|onfinish|onmouse|onexit|onerror|onclick|onkey|onload|onchange|onfocus|onblur)[^><]+/i', $sText, $arrMat ) ) { // 过滤on事件lang js
            $sText = str_replace ( $arrMat [0], $arrMat [1], $sText );
        }
        while ( preg_match ( '/(<[^><]+)(window\.|javascript:|js:|about:|file:|document\.|vbs:|cookie)([^><]*)/i', $sText, $arrMat ) ) {
            $sText = str_replace ( $arrMat [0], $arrMat [1] . $arrMat [3], $sText );
        }
        return $sText;
    }
    
    /**
     * 字符串文本化
     *
     * @param string $sText
     *            待过滤的字符串
     * @return string
     */
    static function text($sText) {
        $sText = self::cleanJs ( $sText );
        // $sText=preg_replace('/\s(?=\s)/','',$sText);// 彻底过滤空格
        $sText = preg_replace ( '/[\n\r\t]/', ' ', $sText );
        /*
         * $sText=str_replace(' ',' ',$sText);
         * $sText=str_replace(' ','',$sText);
         * $sText=str_replace('&nbsp;','',$sText);
         * $sText=str_replace('&','',$sText);
         * $sText=str_replace('=','',$sText);
         * $sText=str_replace('-','',$sText);
         * $sText=str_replace('#','',$sText);
         * $sText=str_replace('%','',$sText);
         * $sText=str_replace('!','',$sText);
         * $sText=str_replace('@','',$sText);
         * $sText=str_replace('^','',$sText);
         * $sText=str_replace('*','',$sText);
         */
        $sText = str_replace ( 'amp;', '', $sText );
        $sText = strip_tags ( $sText );
        $sText = htmlspecialchars ( $sText );
        $sText = str_replace ( "'", "", $sText );
        return $sText;
    }
    
    /**
     * 字符过滤 JS和 HTML标签
     *
     * @param string $sText            
     * @return string
     */
    static public function strip($sText) {
        $sText = trim ( $sText );
        $sText = self::cleanJs ( $sText );
        $sText = strip_tags ( $sText );
        return $sText;
    }
    
    /**
     * 字符 HTML 安全实体
     *
     * @param string $sText            
     * @return string
     */
    static public function html($sText) {
        $sText = trim ( $sText );
        $sText = htmlspecialchars ( $sText );
        return $sText;
    }
    
    /**
     * 字符 HTML 安全显示
     *
     * @param string $sText            
     * @return string
     */
    static public function htmlView($sText) {
        $sText = stripslashes ( $sText );
        $sText = nl2br ( $sText );
        return $sText;
    }
    
    // ######################################################
    // -------------------- 系统安全相关 end ------ -------------
    // ######################################################
    
    /**
     * 返回当前 URL 地址
     *
     * @return string
     */
    static public function getCurrentUrl() {
        return (self::isSsl () ? 'https://' : 'http://') . $_SERVER ['HTTP_HOST'] . $_SERVER ['REQUEST_URI'];
    }
    
    /**
     * 系统提供的 xml 序列化
     *
     * @param string $sText
     *            待过滤的字符串
     * @return string
     */
    static public function xmlEncode($arrData = []) {
        return xml::xmlSerialize ( $arrData );
    }
    
    /**
     * JSON 编码
     *
     * PHP_VERSION >= 5.4
     *
     * @param 待编码的数据 $arrData            
     * @param boo $booUnescaped
     *            JSON 是否编码
     * @return string
     */
    static public function jsonEncode($arrData, $booUnescaped = true) {
        if (version_compare ( PHP_VERSION, '5.4.0', '<' ))
            $booUnescaped = false;
        return $booUnescaped === true ? json_encode ( $arrData, JSON_UNESCAPED_UNICODE ) : json_encode ( $arrData );
    }
    
    // ######################################################
    // -------------------- 运行状态 start --------------------
    // ######################################################
    
    /**
     * PHP 运行模式命令行
     * link http://www.phpddt.com/php/php-sapi.html
     *
     * @return boolean
     */
    static public function isCli() {
        return PHP_SAPI == 'cli' ? true : false;
    }
    
    /**
     * PHP 运行模式 cgi
     * link http://www.phpddt.com/php/php-sapi.html
     *
     * @return boolean
     */
    static public function isCgi() {
        return substr ( PHP_SAPI, 0, 3 ) == 'cgi' ? true : false;
    }
    
    /**
     * 是否为 Ajax 请求行为
     *
     * @return boolean
     */
    static public function isAjax() {
        if (isset ( $_SERVER ['HTTP_X_REQUESTED_WITH'] )) {
            if ('xmlhttprequest' == strtolower ( $_SERVER ['HTTP_X_REQUESTED_WITH'] )) {
                return true;
            }
        }
        
        if (! empty ( $_POST ['ajax'] ) || ! empty ( $_GET ['ajax'] )) {
            return true;
        }
        
        return false;
    }
    
    /**
     * 是否为 Get 请求行为
     *
     * @return boolean
     */
    static public function isGet() {
        return strtolower ( $_SERVER ['REQUEST_METHOD'] ) == 'get';
    }
    
    /**
     * 是否为 Post 请求行为
     *
     * @return boolean
     */
    static public function isPost() {
        return strtolower ( $_SERVER ['REQUEST_METHOD'] ) == 'post';
    }
    
    /**
     * 是否为 window 平台
     *
     * @return boolean
     */
    static public function isWin() {
        return DIRECTORY_SEPARATOR == '\\' ? true : false;
    }
    
    /**
     * 是否为 mac 平台
     *
     * @return boolean
     */
    static public function isMac() {
        return strstr ( PHP_OS, 'Darwin' ) ? true : false;
    }
    
    /**
     * 当前操作系统换行符
     *
     * @return boolean
     */
    static public function osNewline() {
        if (self::isWin ()) {
            return "\n";
        } elseif (self::isMac ()) {
            return "\r";
        } else {
            return "\r\n";
        }
    }
    
    /**
     * 是否启用 https
     *
     * @return boolean
     */
    static public function isSsl() {
        if (isset ( $_SERVER ['HTTPS'] ) && ('1' == $_SERVER ['HTTPS'] || 'on' == strtolower ( $_SERVER ['HTTPS'] ))) {
            return true;
        } elseif (isset ( $_SERVER ['SERVER_PORT'] ) && ('443' == $_SERVER ['SERVER_PORT'])) {
            return true;
        }
        return false;
    }
    
    // ######################################################
    // --------------------- 运行状态 end ---------------------
    // ######################################################
    
    // ######################################################
    // -------------------- 私有函数 start --------------------
    // ######################################################
    
    /*
     * 读取 json 缓存数据
     *
     * @param $sCacheFile
     * @return
     */
    static private function readCache($sCacheFile) {
        return json_decode ( file_get_contents ( $sCacheFile ) );
    }
    
    /**
     * 从命名空间映射获取文件地址
     *
     * @param string $sPrefix
     *            命名空间前缀
     * @param string $sRelativeClass
     *            类名字
     * @return string|false 存在则为文件名，不存则返回 false
     */
    private static function loadMappedFile($sPrefix, $sRelativeClass) {
        if (isset ( self::$arrNamespace [$sPrefix] ) === false) {
            return false;
        }
        
        foreach ( self::$arrNamespace [$sPrefix] as $bBaseDir ) {
            $sFile = $bBaseDir . str_replace ( '\\', '/', $sRelativeClass ) . '.php';
            if (self::requireFile ( $sFile )) {
                return $sFile;
            }
        }
        
        return false;
    }
    
    /**
     * 文件存在则载入文件
     *
     * @param string $sFile
     *            待载入的文件
     * @return bool true 表示存在， false 表示不存在
     */
    private static function requireFile($sFile) {
        if (is_file ( $sFile )) {
            require $sFile;
            return true;
        }
        return false;
    }
    
    /**
     * 扫描一个目录的命名空间
     *
     * @param string $sDirectory
     *            待扫描的目录
     * @param string $sPreFilename            
     * @param array $in
     *            配置参数
     *            ignore 忽略扫描目录
     * @return array 扫描后的命名空间数据
     */
    static private function scanNamespace($sDirectory, $sPreFilename = '', $in = []) {
        $arrDefault = [ 
                'ignore' => [ 
                        '.',
                        '..',
                        '.svn',
                        'node_modules',
                        '.git',
                        '~@~',
                        'www',
                        'ignore' 
                ] 
        ];
        
        if (isset ( $in ['ignore'] )) {
            $arrDefault ['ignore'] = array_merge ( $arrDefault ['ignore'], $in ['ignore'] );
        }
        $in = $arrDefault;
        unset ( $arrDefault );
        
        $arrReturn = [ ];
        
        $sDirectoryPath = realpath ( $sDirectory ) . '/';
        $hDir = opendir ( $sDirectoryPath );
        
        while ( ($sFilename = readdir ( $hDir )) !== false ) {
            $sPath = $sDirectoryPath . $sFilename;
            if (is_dir ( $sPath )) { // 目录
                if (in_array ( $sFilename, $in ['ignore'] )) { // 排除特殊目录
                    continue;
                } else {
                    if ($in ['file'] === false) {
                        $arrReturn [] = str_replace ( '/', '\\', $sPreFilename . $sFilename );
                    }
                    
                    // 递归子目录
                    $arrReturn = array_merge ( $arrReturn, self::scanNamespace ( $sPath, $sPreFilename . $sFilename . '/', $in ) );
                }
            } else {
                self::throwException ( sprintf ( "\$sPath:%s is not a valid path", $sPath ) );
            }
        }
        
        return $arrReturn;
    }
    
    /**
     * 读取缓存时间配置
     *
     * @param string $sId            
     * @return number
     */
    static private function cacheTime_($sId) {
        $nCacheTime = 0;
        if (! empty ( $GLOBALS ['option'] ['runtime_cache_times'] [$sId] )) {
            $nCacheTime = intval ( $GLOBALS ['option'] ['runtime_cache_times'] [$sId] );
            return $nCacheTime;
        }
        
        foreach ( $GLOBALS ['option'] ['runtime_cache_times'] as $sKey => $nValue ) {
            $sKeyCache = str_replace ( '_*', '', $sKey );
            if ($sKeyCache == $sId) {
                return $GLOBALS ['option'] ['runtime_cache_times'] [$sKey];
                break;
            }
        }
        
        return $nCacheTime;
    }
    
    /**
     * 分析 in 中参数
     *
     * @param string $sValue            
     * @return
     *
     */
    static private function parseUrl_($sValue) {
        if (strpos ( $sValue, ':' ) !== false) {
            $sValue = explode ( ':', $sValue );
            return self::in ( $sValue [0] ) !== null ? self::in ( $sValue [0] ) : $sValue [1];
        } else {
            return self::in ( $sValue );
        }
    }
    
    // ######################################################
    // --------------------- 私有函数 end ---------------------
    // ######################################################
}

/**
 * array_column 兼容支持
 *
 * PHP_VERSION >= 5.4
 */
if (! function_exists ( 'array_column' )) {
    
    /**
     * 返回输入数组中某个单一列的值
     *
     * @param array $arrArray
     *            必需。规定要使用的多维数组（记录集）
     * @param string $sColumnKey
     *            必需。需要返回值的列。可以是索引数组的列的整数索引，或者是关联数组的列的字符串键值。该参数也可以是 NULL，此时将返回整个数组（配合 index_key 参数来重置数组键的时候，非常有用）。
     * @param string $sIndexKey
     *            可选。用作返回数组的索引/键的列。
     * @return array
     */
    function array_column(array $arrArray, $sColumnKey, $sIndexKey = null) {
        $arrResult = [ ];
        foreach ( $arrArray as $arr ) {
            if (! is_array ( $arr ))
                continue;
            if (is_null ( $sColumnKey )) {
                $mixValue = $arr;
            } else {
                $mixValue = $arr [$sColumnKey];
            }
            if (! is_null ( $sIndexKey )) {
                $sKey = $arr [$sIndexKey];
                $arrResult [$sKey] = $mixValue;
            } else {
                $arrResult [] = $mixValue;
            }
        }
        return $arrResult;
    }
}
