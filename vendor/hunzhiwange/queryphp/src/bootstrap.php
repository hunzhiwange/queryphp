<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
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
 * 框架引导文件
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2016.11.17
 * @version 1.0
 */
if (version_compare ( PHP_VERSION, '5.5.0', '<' ))
    die ( 'PHP 5.5.0 OR Higher' );

if (defined ( 'Q_VER' ))
    return;

ini_set ( 'default_charset', 'utf8' );

/**
 * QueryPHP 路径定义
 */
define ( 'Q_PATH', __DIR__ );

/**
 * QueryPHP 调试
 */
defined ( 'Q_DEBUG' ) or define ( 'Q_DEBUG', false );

/**
 * QueryPHP 开发模式
 * 开发模式=develop、测试模式=test、线上模式online
 */
defined ( 'Q_DEVELOPMENT' ) or define ( 'Q_DEVELOPMENT', 'online' );

/**
 * QueryPHP 是否命令行工具模式
 */
defined ( 'Q_CONSOLE' ) or define ( 'Q_CONSOLE', false );

/**
 * QueryPHP 版本 | 2017.03.31
 */
define ( 'Q_VER', '4.0' );

/**
 * QueryPHP 核心函数库和一些公用函数
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
    private static $arrNamespace = [ ];
    
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
     * 项目类管理
     *
     * @return \Q\mvc\project
     */
    public static function project() {
        return \Q\mvc\project::bootstrap ();
    }
    
    /**
     * 自动载入
     * 基于 PSR-4 规范构建
     *
     * @param string $sClassName
     *            当前的类名
     * @return mixed
     */
    public static function autoLoad($sClassName) {
        if (static::$bAutoLoad === false) {
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
            return static::requireFile_ ( $sFile );
        } else {
            $sPrefix = $sClassName;
            while ( false !== ($intPos = strrpos ( $sPrefix, '\\' )) ) {
                $sPrefix = substr ( $sClassName, 0, $intPos + 1 );
                $sRelativeClass = substr ( $sClassName, $intPos + 1 );
                $sMappedFile = static::loadMappedFile_ ( $sPrefix, $sRelativeClass );
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
     * @param string|array $mixNamespace
     *            命名空间名字
     * @param string $sPackage
     *            命名空间路径
     * @param 支持参数 $in
     *            ignore 忽略扫描目录
     *            force 是否强制更新缓存
     * @return void
     */
    public static function import($mixNamespace, $sPackage, $in = []) {
        $in = array_merge ( [ 
                'ignore' => [ ],
                'force' => false 
        ], $in );
        
        if (! is_dir ( $sPackage )) {
            \Exceptions::throws ( "Package:'{$sPackage}' does not exists." );
        }
        
        // 包路径
        $sPackagePath = realpath ( $sPackage ) . '/';
        $sCache = $sPackagePath . static::NAMESPACE_CACHE;
        
        if ($in ['force'] === true || ! is_file ( $sCache )) {
            // 扫描命名空间
            $arrPath = static::scanNamespace_ ( $sPackagePath, $sPackagePath, [ 
                    'ignore' => $in ['ignore'] 
            ] );
            
            // 写入文件
            if (! file_put_contents ( $sCache, json_encode ( $arrPath ) )) {
                \Exceptions::throws ( sprintf ( 'Can not create cache file: %s', $sCache ) );
            }
        } else {
            $arrPath = static::readCache ( $sCache );
        }
        
        if (! is_array ( $mixNamespace )) {
            $strTemp = $mixNamespace;
            $mixNamespace = [ ];
            $mixNamespace [] = $strTemp;
        }
        
        foreach ( $mixNamespace as $sNamespace ) {
            static::addNamespace ( $sNamespace, $sPackage );
            foreach ( $arrPath as $sPath ) {
                static::addNamespace ( $sNamespace . '\\' . $sPath, $sPackage . '/' . $sPath );
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
        if (isset ( static::$arrNamespace [$sNamespace] ) === false) {
            static::$arrNamespace [$sNamespace] = [ ];
        }
        
        foreach ( $mixBaseDir as $sBase ) {
            $sBase = rtrim ( $sBase, '/' ) . DIRECTORY_SEPARATOR;
            $sBase = rtrim ( $sBase, DIRECTORY_SEPARATOR ) . '/';
            
            // 优先插入
            if ($in ['prepend'] === true) {
                array_unshift ( static::$arrNamespace [$sNamespace], $sBase );
            } else {
                array_push ( static::$arrNamespace [$sNamespace], $sBase );
            }
        }
    }
    
    /**
     * 导入 Composer PSR-4
     *
     * @param string $strVendor            
     * @return void
     */
    public static function importComposer($strVendor) {
        if (is_file ( $strVendor . '/composer/autoload_psr4.php' )) {
            $arrMap = require $strVendor . '/composer/autoload_psr4.php';
            foreach ( $arrMap as $sNamespace => $sPath ) {
                static::addNamespace ( $sNamespace, $sPath );
            }
        }
    }
    
    /**
     * 获取命名空间路径
     *
     * @param string $sNamespace            
     * @return string|null
     */
    public static function getNamespace($sNamespace) {
        $sNamespace .= '\\';
        return isset ( static::$arrNamespace [$sNamespace] ) ? array_shift ( static::$arrNamespace [$sNamespace] ) : null;
    }
    
    /**
     * 设置自动载入是否启用
     *
     * @param bool $bAutoload
     *            true　表示启用
     * @return boolean
     */
    public static function setAutoload($bAutoload) {
        if (! is_bool ( $bAutoload )) {
            $bAutoload = $bAutoload ? true : false;
        } else {
            $bAutoload = &$bAutoload;
        }
        
        $bOldValue = static::$bAutoLoad;
        static::$bAutoLoad = $bAutoload;
        return $bOldValue;
    }
    
    /**
     * 单一实例
     *
     * @param string $sClass            
     * @param mixed $mixArgs            
     * @param string $sMethod            
     * @param mixed $mixMethodArgs            
     * @return object
     */
    public static function instance($sClass, $mixArgs = null, $sMethod = null, $mixMethodArgs = null) {
        $sIdentify = $sClass . serialize ( $mixArgs ) . $sMethod . serialize ( $mixMethodArgs ); // 惟一识别号
        
        if (! isset ( static::$arrInstances [$sIdentify] )) {
            if (class_exists ( $sClass )) {
                $oClass = $mixArgs === null ? new $sClass () : new $sClass ( $mixArgs );
                if (! empty ( $sMethod ) && method_exists ( $oClass, $sMethod )) {
                    static::$arrInstances [$sIdentify] = $mixMethodArgs === null ? call_user_func ( [ 
                            $oClass,
                            $sMethod 
                    ] ) : call_user_func_array ( [ 
                            $oClass,
                            $sMethod 
                    ], is_array ( $mixMethodArgs ) ? $mixMethodArgs : [ 
                            $mixMethodArgs 
                    ] );
                } else {
                    static::$arrInstances [$sIdentify] = $oClass;
                }
            } else {
                \Exceptions::throws ( sprintf ( 'class %s is not exists', $sClass ) );
            }
        }
        
        return static::$arrInstances [$sIdentify];
    }
    
    /**
     * 动态创建实例对象
     *
     * @param string $strClass            
     * @param array $arrArgs            
     * @return mixed
     */
    public static function newInstanceArgs($strClass, $arrArgs) {
        $objClass = new \ReflectionClass ( $strClass );
        if ($objClass->getConstructor ()) {
            return $objClass->newInstanceArgs ( $arrArgs );
        } else {
            return $objClass->newInstanceWithoutConstructor ();
        }
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
    public static function cache($sId, $mixData = '', $arrOption = null, $sBackendClass = null) {
        static $arrCache;
        
        if (! is_array ( $arrOption )) {
            $arrOption = [ ];
        }
        $arrOption = array_merge ( [ 
                'cache_time' => static::cacheTime_ ( $sId, $GLOBALS ['~@option'] ['runtime_cache_time'] ),
                'cache_prefix' => $GLOBALS ['~@option'] ['runtime_cache_prefix'],
                'cache_backend' => ! is_null ( $sBackendClass ) ? $sBackendClass : $GLOBALS ['~@option'] ['runtime_cache_backend'] 
        ], $arrOption );
        
        if (empty ( $arrCache [$arrOption ['cache_backend']] )) {
            $arrObjectOption = [ ];
            foreach ( [ 
                    'runtime_file_path',
                    'runtime_memcache_compressed',
                    'runtime_memcache_persistent',
                    'runtime_memcache_servers',
                    'runtime_memcache_host',
                    'runtime_memcache_port' 
            ] as $sObjectOption ) {
                $arrObjectOption [$sObjectOption] = $GLOBALS ['~@option'] [$sObjectOption];
            }
            $arrObjectOption ['path_cache_file'] = \Q::project ()->path_cache_file;
            $arrCache [$arrOption ['cache_backend']] = static::project ()->make ( $arrOption ['cache_backend'], $arrOption )->setObjectOption ( $arrObjectOption );
        }
        
        if ($mixData === '') {
            // 强制刷新页面数据
            if (static::in ( $GLOBALS ['~@option'] ['runtime_cache_force_name'] ) == 1) {
                return false;
            }
            return $arrCache [$arrOption ['cache_backend']]->get ( $sId, $arrOption );
        }
        if ($mixData === null) {
            return $arrCache [$arrOption ['cache_backend']]->delele ( $sId, $arrOption );
        }
        return $arrCache [$arrOption ['cache_backend']]->set ( $sId, $mixData, $arrOption );
    }
    
    /**
     * 读取、设置、删除配置值
     *
     * @param mixed $mixName            
     * @param mixed $mixValue            
     * @param mixed $mixDefault            
     * @return mixed
     */
    public static function option($mixName = '', $mixValue = '', $mixDefault = null) {
        static $objOption;
        if (! $objOption) {
            $objOption = static::project ()->option;
        }
        
        if (is_null ( $mixName )) {
            return static::__callStatic ( 'option', func_get_args () );
        }
        
        // 返回配置数据
        if (is_string ( $mixName ) && $mixValue === '') {
            return $objOption->get ( $mixName, $mixDefault );
        }        

        // 删除值
        elseif ($mixValue === null) {
            $objOption->delete ( $mixName );
        }         

        // 设置值
        else {
            $objOption->set ( $mixName, $mixValue );
        }
        
        // 返回全部
        return $GLOBALS ['~@option'] = $objOption->get ();
    }
    
    /**
     * 产品国际化支持
     *
     * @param 语言 $sValue            
     * @return mixed
     */
    public static function i18n($sValue = null/*argvs*/){
        static $objI18n;
        
        if (is_null ( $sValue )) {
            return static::__callStatic ( 'i18n', func_get_args () );
        }
        
        // 不开启
        if (empty ( $GLOBALS ['~@option'] ['i18n_on'] ) || ! static::$booI18nOn) {
            if (func_num_args () > 1) { // 代入参数
                $sValue = call_user_func_array ( 'sprintf', func_get_args () );
            }
            return $sValue;
        }
        
        if (! $objI18n) {
            $arrObjectOption = [ ];
            foreach ( [ 
                    'i18n_default',
                    'i18n_auto_accept' 
            ] as $sObjectOption ) {
                $arrObjectOption [$sObjectOption] = $GLOBALS ['~@option'] [$sObjectOption];
            }
            $objI18n = static::project ()->i18n->setObjectOption ( $arrObjectOption );
        }
        
        // 返回当地语句
        $sValue = call_user_func_array ( [ 
                $objI18n,
                'getText' 
        ], func_get_args () );
        return $sValue;
    }
    
    /**
     * 生成路由地址
     *
     * @param string $sUrl            
     * @param array $arrParams            
     * @param array $in
     *            suffix boolean 是否包含后缀
     *            normal boolean 是否为普通 url
     *            subdomain string 子域名
     * @return string
     */
    public static function url($sUrl, $arrParams = [], $in = []) {
        $in = array_merge ( [ 
                'suffix' => true,
                'normal' => false,
                'subdomain' => 'www' 
        ], $in );
        
        $in ['args_app'] = \Q\mvc\project::ARGS_APP;
        $in ['args_controller'] = \Q\mvc\project::ARGS_CONTROLLER;
        $in ['args_action'] = \Q\mvc\project::ARGS_ACTION;
        
        // 以 “/” 开头的为自定义URL
        $in ['custom'] = false;
        if (0 === strpos ( $sUrl, '/' )) {
            $in ['custom'] = true;
        }         

        // 普通 url
        else {
            if ($sUrl != '') {
                if (! strpos ( $sUrl, '://' )) {
                    $sUrl = $_GET [$in ['args_app']] . '://' . $sUrl;
                }
                
                // 解析 url
                $arrArray = parse_url ( $sUrl );
            } else {
                $arrArray = [ ];
            }
            
            $in ['app'] = isset ( $arrArray ['scheme'] ) ? $arrArray ['scheme'] : $_GET [$in ['args_app']]; // APP
                                                                                                            
            // 分析获取模块和操作(应用)
            if (! empty ( $arrParams [$in ['args_app']] )) {
                $in ['app'] = $arrParams [$in ['args_app']];
                unset ( $arrParams [$in ['args_app']] );
            }
            if (! empty ( $arrParams [$in ['args_controller']] )) {
                $in ['controller'] = $arrParams [$in ['args_controller']];
                unset ( $arrParams [$in ['args_controller']] );
            }
            if (! empty ( $arrParams [$in ['args_action']] )) {
                $in ['action'] = $arrParams [$in ['args_action']];
                unset ( $arrParams [$in ['args_action']] );
            }
            if (isset ( $arrArray ['path'] )) {
                if (! isset ( $in ['controller'] )) {
                    if (! isset ( $arrArray ['host'] )) {
                        $in ['controller'] = $_GET [\Q\mvc\project::ARGS_CONTROLLER];
                    } else {
                        $in ['controller'] = $arrArray ['host'];
                    }
                }
                
                if (! isset ( $in ['action'] )) {
                    $in ['action'] = substr ( $arrArray ['path'], 1 );
                }
            } else {
                if (! isset ( $in ['controller'] )) {
                    $in ['controller'] = $_GET [\Q\mvc\project::ARGS_CONTROLLER];
                }
                if (! isset ( $in ['action'] )) {
                    $in ['action'] = $arrArray ['host'];
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
        if (($GLOBALS ['~@option'] ['url_model'] == 'pathinfo' && $in ['normal'] === false) || $in ['custom'] === true) {
            // 非自定义 url
            if ($in ['custom'] === false) {
                // 额外参数
                $sStr = '/';
                foreach ( $arrParams as $sVar => $sVal ) {
                    $sStr .= $sVar . '/' . urlencode ( $sVal ) . '/';
                }
                $sStr = substr ( $sStr, 0, - 1 );
                
                // 分析 url
                $sUrl = ($GLOBALS ['~@url'] ['url_enter'] !== '/' ? $GLOBALS ['~@url'] ['url_enter'] : '') . ($GLOBALS ['~@option'] ['default_app'] != $in ['app'] ? '/' . $in ['app'] . '/' : '/');
                
                if ($sStr) {
                    $sUrl .= $in ['controller'] . '/' . $in ['action'] . $sStr;
                } else {
                    $sTemp = '';
                    if ($GLOBALS ['~@option'] ['default_controller'] != $in ['controller'] || $GLOBALS ['~@option'] ['default_action'] != $in ['action']) {
                        $sTemp .= $in ['controller'];
                    }
                    if ($GLOBALS ['~@option'] ['default_action'] != $in ['action']) {
                        $sTemp .= '/' . $in ['action'];
                    }
                    
                    if ($sTemp == '') {
                        $sUrl = rtrim ( $sUrl, '/' . '/' );
                    } else {
                        $sUrl .= $sTemp;
                    }
                    unset ( $sTemp );
                }
            }             

            // 自定义 url
            else {
                // 自定义支持参数变量替换
                if (strpos ( $sUrl, '{' ) !== false) {
                    $sUrl = preg_replace_callback ( "/{(.+?)}/", function ($arrMatches) use(&$arrParams) {
                        if (isset ( $arrParams [$arrMatches [1]] )) {
                            $sReturn = $arrParams [$arrMatches [1]];
                            unset ( $arrParams [$arrMatches [1]] );
                        } else {
                            $sReturn = $arrMatches [1];
                        }
                        return $sReturn;
                    }, $sUrl );
                }
                
                // 额外参数
                $sStr = '/';
                foreach ( $arrParams as $sVar => $sVal ) {
                    $sStr .= $sVar . '/' . urlencode ( $sVal ) . '/';
                }
                $sStr = substr ( $sStr, 0, - 1 );
                
                $sUrl .= $sStr;
            }
            
            if ($in ['suffix'] && $sUrl) {
                $sUrl .= $in ['suffix'] === true ? $GLOBALS ['~@option'] ['url_html_suffix'] : $in ['suffix'];
            }
        }         

        // 普通url模式
        else {
            $sStr = '';
            foreach ( $arrParams as $sVar => $sVal ) {
                $sStr .= $sVar . '=' . urlencode ( $sVal ) . '&';
            }
            $sStr = rtrim ( $sStr, '&' );
            
            $sTemp = '';
            if ($in ['normal'] === true || $GLOBALS ['~@option'] ['default_app'] != $in ['app']) {
                $sTemp [] = $in ['args_app'] . '=' . $in ['app'];
            }
            if ($GLOBALS ['~@option'] ['default_controller'] != $in ['controller']) {
                $sTemp [] = $in ['args_controller'] . '=' . $in ['controller'];
            }
            if ($GLOBALS ['~@option'] ['default_action'] != $in ['action']) {
                $sTemp [] = $in ['args_action'] . '=' . $in ['action'];
            }
            if ($sStr) {
                $sTemp [] = $sStr;
            }
            if (! empty ( $sTemp )) {
                $sTemp = '?' . implode ( '&', $sTemp );
            }
            $sUrl = ($in ['normal'] === true || $GLOBALS ['~@url'] ['url_enter'] !== '/' ? $GLOBALS ['~@url'] ['url_enter'] : '') . $sTemp;
            unset ( $sTemp );
        }
        
        // 子域名支持
        if ($GLOBALS ['~@option'] ['url_make_subdomain_on'] === true) {
            if ($in ['subdomain']) {
                $sUrl = static::urlFull_ ( $in ['subdomain'] ) . $sUrl;
            }
        }
        
        return $sUrl;
    }
    
    /**
     * 响应请求
     *
     * @return mixed
     */
    public static function response() {
        return call_user_func_array ( [ 
                'Q\request\response',
                'singleton' 
        ], func_get_args () );
    }
    
    // ######################################################
    // ------------------- 框架核心功能 end -------------------
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
    public static function varType($mixVar, $sType) {
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
                        return static::checkArray ( $mixVar, $sType [1] );
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
                return static::isKindOf ( $mixVar, implode ( ':', $sType ) );
        }
    }
    
    /**
     * 验证是否为同一回调
     *
     * @param callback $calA            
     * @param callback $calkB            
     * @return boolean
     */
    public static function isSameCallback($calA, $calB) {
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
    public static function isThese($mixVar, $mixTypes) {
        if (! static::varType ( $mixTypes, 'string' ) && ! static::checkArray ( $mixTypes, [ 
                'string' 
        ] )) {
            \Exceptions::throws ( \Q::i18n ( '正确格式:参数必须为 string 或 各项元素为 string 的数组' ) );
        }
        
        if (is_string ( $mixTypes )) {
            $mixTypes = [ 
                    $mixTypes 
            ];
        }
        
        foreach ( $mixTypes as $sType ) { // 类型检查
            if (static::varType ( $mixVar, $sType )) {
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
    public static function isKindOf($mixSubClass, $sBaseClass) {
        if (static::classExists ( $sBaseClass, true )) { // 接口
            return static::isImplementedTo ( $mixSubClass, $sBaseClass );
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
            
            return static::isKindOf ( $sParClass, $sBaseClass );
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
    public static function isImplementedTo($mixClass, $sInterface, $bStrictly = false) {
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
            return static::isImplementedTo ( $sParName, $sInterface, $bStrictly );
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
    public static function classExists($sClassName, $bInter = false, $bAutoload = false) {
        if (! is_string ( $sClassName )) {
            \Exceptions::throws ( 'classExists first args must be a string!' );
        }
        $bAutoloadOld = static::setAutoload ( $bAutoload );
        $sFuncName = $bInter ? 'interface_exists' : 'class_exists';
        $bResult = $sFuncName ( $sClassName );
        static::setAutoload ( $bAutoloadOld );
        return $bResult;
    }
    
    /**
     * 验证数组中的每一项格式化是否正确
     *
     * @param array $arrArray            
     * @param array $arrTypes            
     * @return boolean
     */
    public static function checkArray($arrArray, array $arrTypes) {
        if (! is_array ( $arrArray )) { // 不是数组直接返回
            return false;
        }
        
        // 判断数组内部每一个值是否为给定的类型
        foreach ( $arrArray as &$mixValue ) {
            $bRet = false;
            foreach ( $arrTypes as $mixType ) {
                if (static::varType ( $mixValue, $mixType )) {
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
    public static function oneImensionArray($arrArray) {
        return count ( $arrArray ) == count ( $arrArray, 1 );
    }
    
    /**
     * 数组合并支持 + 算法
     *
     * @param array $arrOption            
     * @param boolean $booRecursion            
     * @return array
     */
    public static function arrayMergePlus($arrOption, $booRecursion = true) {
        $arrExtend = [ ];
        foreach ( $arrOption as $strKey => $mixTemp ) {
            if (strpos ( $strKey, '+' ) === 0) {
                $arrExtend [ltrim ( $strKey, '+' )] = $mixTemp;
                unset ( $arrOption [$strKey] );
            }
        }
        foreach ( $arrExtend as $strKey => $mixTemp ) {
            if (isset ( $arrOption [$strKey] ) && is_array ( $arrOption [$strKey] ) && is_array ( $mixTemp )) {
                $arrOption [$strKey] = array_merge ( $arrOption [$strKey], $mixTemp );
                if ($booRecursion === true) {
                    $arrOption [$strKey] = static::arrayMergePlus ( $arrOption [$strKey], $booRecursion );
                }
            } else {
                $arrOption [$strKey] = $mixTemp;
            }
        }
        return $arrOption;
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
    public static function tidyPath($sPath, $bUnix = true) {
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
    public static function makeDir($sDir, $nMode = 0777) {
        if (is_dir ( $sDir )) {
            return true;
        }
        
        if (is_string ( $sDir )) {
            $sDir = explode ( '/', str_replace ( '\\', '/', trim ( $sDir, '/' ) ) );
        }
        
        $sCurDir = static::isWin () ? '' : '/';
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
     * @return array
     */
    public static function listDir($sDir, $arrIn = []) {
        $arrIn = array_merge ( [ 
                'fullpath' => FALSE,
                'return' => 'dir', // file dir both
                'filterdir' => [ 
                        '.',
                        '..',
                        '.svn',
                        '.git',
                        'node_modules',
                        '.gitkeep' 
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
                ] ) && (! $arrIn ['filterext'] ? true : (in_array ( static::getExtName ( $sFile, 2 ), $arrIn ['filterext'] ) ? false : true))) {
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
    public static function getExtName($sFileName, $nCase = 0) {
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
     * @return string
     */
    public static function getIp() {
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
     * @return void
     */
    public static function urlRedirect($sUrl, $nTime = 0, $sMsg = '') {
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
                include (Q_PATH . '/~@~/tpl/url.php'); // 包含跳转页面模板
            }
            exit ();
        } else {
            $sHeader = "<meta http-equiv='Refresh' content='{$nTime};URL={$sUrl}'>";
            if ($nTime == 0) {
                $sHeader = '';
            }
            include (Q_PATH . '/~@~/tpl/url.php'); // 包含跳转页面模板
            exit ();
        }
    }
    
    /**
     * 路由 URL 跳转
     *
     * @param string $sUrl            
     * @param 额外参数 $in
     *            params url 额外参数
     *            message 消息
     *            time 停留时间，0表示不停留
     * @return void
     */
    public static function redirect($sUrl, $in = []) {
        $in = array_merge ( [ 
                'params' => [ ],
                'message' => '',
                'time' => 0 
        ], $in );
        
        \Q::urlRedirect ( \Q::url ( $sUrl, $in ['params'] ), $in ['time'], $in ['message'] );
    }
    
    /**
     * 分析 url 数据
     * like [home://blog/index?arg1=1&arg2=2]
     *
     * @param string $sUrl            
     * @return array
     */
    public static function parseMvcUrl($sUrl) {
        $arrData = [ ];
        
        // 解析 url
        if (strpos ( $sUrl, '://' ) === false) {
            $sUrl = 'QueryPHP://' . $sUrl;
        }
        $sUrl = parse_url ( $sUrl );
        
        // 应用
        if ($sUrl ['scheme'] != 'QueryPHP') {
            $arrData [\Q\mvc\project::ARGS_APP] = $sUrl ['scheme'];
        }
        
        // 控制器
        $arrData [\Q\mvc\project::ARGS_CONTROLLER] = $sUrl ['host'];
        
        // 方法
        if (isset ( $sUrl ['path'] ) && $sUrl ['path'] != '/') {
            $arrData [\Q\mvc\project::ARGS_ACTION] = ltrim ( $sUrl ['path'], '/' );
        }
        
        // 额外参数
        if (isset ( $sUrl ['query'] )) {
            foreach ( explode ( '&', $sUrl ['query'] ) as $strQuery ) {
                $strQuery = explode ( '=', $strQuery );
                $arrData [$strQuery [0]] = $strQuery [1];
            }
        }
        
        return $arrData;
    }
    
    /**
     * 返回当前 URL 地址
     *
     * @return string
     */
    public static function getCurrentUrl() {
        return (static::isSsl () ? 'https://' : 'http://') . $_SERVER ['HTTP_HOST'] . $_SERVER ['REQUEST_URI'];
    }
    
    /**
     * 系统提供的 xml 序列化
     *
     * @param array $arrData
     *            待过滤的字符串
     * @return string
     */
    public static function xmlSerialize($arrData = []) {
        return static::xml ()->xmlSerialize ( $arrData );
    }
    
    /**
     * 系统提供的 xml 反序列化
     *
     * @param string $sText
     *            待反序列化的 xml 字符串
     * @return string
     */
    public static function xmlUnSerialize($sText) {
        return static::xml ()->xmlUnSerialize ( $sText );
    }
    
    /**
     * JSON 编码
     *
     * @param 待编码的数据 $arrData            
     * @param int $intOptions            
     * @return string
     */
    public static function jsonEncode($arrData, $intOptions = JSON_UNESCAPED_UNICODE) {
        return json_encode ( $arrData, $intOptions );
    }
    
    /**
     * 数组数据格式化
     *
     * @param mixed $mixInput            
     * @param string $sDelimiter            
     * @param boolean $bAllowedEmpty            
     * @return mixed
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
    
    // ######################################################
    // -------------------- 常用辅助方法 end ------- ------------
    // ######################################################
    
    // ######################################################
    // -------------------- 运行状态 start --------------------
    // ######################################################
    
    /**
     * 是否为 window 平台
     *
     * @return boolean
     */
    public static function isWin() {
        return DIRECTORY_SEPARATOR == '\\' ? true : false;
    }
    
    /**
     * 是否为 mac 平台
     *
     * @return boolean
     */
    public static function isMac() {
        return strstr ( PHP_OS, 'Darwin' ) ? true : false;
    }
    
    /**
     * 当前操作系统换行符
     *
     * @return boolean
     */
    public static function osNewline() {
        if (static::isWin ()) {
            return "\n";
        } elseif (static::isMac ()) {
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
    public static function isSsl() {
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
    public static function getHost() {
        return isset ( $_SERVER ['HTTP_X_FORWARDED_HOST'] ) ? $_SERVER ['HTTP_X_FORWARDED_HOST'] : (isset ( $_SERVER ['HTTP_HOST'] ) ? $_SERVER ['HTTP_HOST'] : '');
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
     * @return json
     */
    private static function readCache($sCacheFile) {
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
    private static function loadMappedFile_($sPrefix, $sRelativeClass) {
        if (isset ( static::$arrNamespace [$sPrefix] ) === false) {
            return false;
        }
        
        foreach ( static::$arrNamespace [$sPrefix] as $bBaseDir ) {
            $sFile = $bBaseDir . str_replace ( '\\', '/', $sRelativeClass ) . '.php';
            if (static::requireFile_ ( $sFile )) {
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
    private static function requireFile_($sFile) {
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
     * @param string $sRootDir
     *            根目录
     * @param array $in
     *            参数配置
     *            ignore 忽略扫描目录
     *            add_more 是否为增加更多还是覆盖
     *            full_path 是否返回完整路径
     * @return array 扫描后的命名空间数据
     */
    private static function scanNamespace_($sDirectory, $sRootDir = '', $in = []) {
        $in = array_merge ( [ 
                'ignore' => [ ],
                'add_more' => true,
                'full_path' => false 
        ], $in );
        
        $arrDefaultIgnore = [ 
                '.',
                '..',
                '.svn',
                'node_modules',
                '.git',
                '~@~',
                'www',
                'ignore',
                '.gitkeep' 
        ];
        
        if ($in ['add_more'] === true) {
            foreach ( $in ['ignore'] as $sIgnore ) {
                if (! in_array ( $sIgnore, $arrDefaultIgnore )) {
                    $arrDefaultIgnore [] = $sIgnore;
                }
            }
        } else {
            $arrDefaultIgnore = $in ['ignore'];
        }
        
        $arrReturn = [ ];
        $sDirectoryPath = realpath ( $sDirectory ) . '/';
        $hDir = opendir ( $sDirectoryPath );
        
        while ( ($sFilename = readdir ( $hDir )) !== false ) {
            $sPath = $sDirectoryPath . $sFilename;
            if (is_dir ( $sPath )) { // 目录
                if (in_array ( $sFilename, $arrDefaultIgnore )) { // 排除特殊目录
                    continue;
                } else {
                    // 返回完整路径
                    if ($in ['full_path'] === true) {
                        $arrReturn [] = $sPath;
                    } else {
                        $arrReturn [] = str_replace ( str_replace ( '/', '\\', $sRootDir ), '', str_replace ( '/', '\\', $sPath ) );
                    }
                    
                    // 递归子目录
                    $arrReturn = array_merge ( $arrReturn, static::scanNamespace_ ( $sPath, $sRootDir, $in ) );
                }
            }
        }
        
        return $arrReturn;
    }
    
    /**
     * 读取缓存时间配置
     *
     * @param string $sId            
     * @param int $intDefaultTime            
     * @return number
     */
    private static function cacheTime_($sId, $intDefaultTime = 0) {
        if (isset ( $GLOBALS ['~@option'] ['runtime_cache_times'] [$sId] )) {
            return $GLOBALS ['~@option'] ['runtime_cache_times'] [$sId];
        }
        
        foreach ( $GLOBALS ['~@option'] ['runtime_cache_times'] as $sKey => $nValue ) {
            $sKeyCache = '/^' . str_replace ( '*', '(\S+)', $sKey ) . '$/';
            if (preg_match ( $sKeyCache, $sId, $arrRes )) {
                return $GLOBALS ['~@option'] ['runtime_cache_times'] [$sKey];
            }
        }
        
        return $intDefaultTime;
    }
    
    /**
     * 返回完整 URL 地址
     *
     * @param string $sDomain            
     * @param string $sHttpPrefix            
     * @param string $sHttpSuffix            
     * @return string
     */
    private static function urlFull_($sDomain = '', $sHttpPrefix = '', $sHttpSuffix = '') {
        static $sHttpPrefix = '', $sHttpSuffix = '';
        if (! $sHttpPrefix) {
            $sHttpPrefix = static::isSsl () ? 'https://' : 'http://';
            $sHttpSuffix = $GLOBALS ['~@option'] ['url_router_domain_top'];
        }
        return $sHttpPrefix . ($sDomain && $sDomain != '*' ? $sDomain . '.' : '') . $sHttpSuffix;
    }
    
    // ######################################################
    // --------------------- 私有函数 end ---------------------
    // ######################################################
    
    /**
     * 拦截查询静态方法 facades
     *
     * @param 方法名 $sMethod            
     * @param 参数 $arrArgs            
     * @return boolean
     */
    public static function __callStatic($sMethod, $arrArgs) {
        if (($objFacades = static::project ()->make ( $sMethod ))) {
            return $objFacades;
        }
        \Exceptions::throws ( static::i18n ( '未实现 facades 方法 %s', $sMethod ) );
    }
}

/**
 * QueryPHP 自动载入
 */
spl_autoload_register ( [ 
        'Q',
        'autoload' 
] );

/**
 * QueryPHP 注册框架命名空间
 */
\Q::import ( 'Q', Q_PATH, [ 
        'ignore' => [ 
                'resource' 
        ] 
] );

/**
 * QueryPHP 系统警告处理
 */
set_exception_handler ( [ 
        'Q\exception\handle',
        'exceptionHandle' 
] );

/**
 * QueryPHP 系统错误处理
 */
if (Q_DEBUG === TRUE) {
    set_error_handler ( [ 
            'Q\exception\handle',
            'errorHandle' 
    ] );
    
    register_shutdown_function ( [ 
            'Q\exception\handle',
            'shutdownHandle' 
    ] );
}
