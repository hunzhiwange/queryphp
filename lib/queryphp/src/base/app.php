<?php
/*
 * [$QueryPHP] (C)QueryPHP.COM Since 2016.11.17.
 * 自动载入
 *
 * <The old is doyouhaobaby.com since 2010.10.04.>
 * @author dyhb<635750556@qq.com>
 * @version $$
 * @date 2016.11.18
 * @since 1.0
 */
namespace Q\base;

use Q, Q\i18n\i18n, Q\i18n\tool;

/**
 * 应用程序对象
 *
 * @since 2016年11月18日 下午11:29:50
 * @author dyhb
 */
class app {
    
    /**
     * 应用程序属性
     */
    protected $arrProp = [ 
            
            /**
             * 项目基本
             */
            // 'project_name' => '',
            'project_path' => '',
            'com_path' => '', // 公共组件
            'app_path' => '', // 应用基础路径
            'apppublic_path' => '', // 应用公共资源路径
            'vendor_path' => '', // Composer 公共组件
            
            /**
             * 应用基本
             */
            'app_name' => '', // 应用名字
            'controller_name' => '', // 控制器名字
            'action_name' => '', // 方法名字
            'appoption_path' => '', // 配置默认目录
            'appoption_name' => '', // 配置默认名字
            'apptheme_path' => '', // 主题目录
            'apptheme_name' => '', // 主题名字
            'appthemebackup_path' => '', // 备用主题目录
            'appi18n_path' => '', // 国际化目录
            'appi18n_name' => '', // i18n名字
            'appi18nextend_path' => [ ], // 国际化目录扩展，系统将会扫描这些目录
            
            /**
             * URL 地址
             */
            'url_app' => '', // php文件所在 url 地址如 http://myapp.com/index.php
            'url_root' => '', // 网站 root http://myapp.com
            'url_public' => '', // 网站 public http://myapp.com/public
            
            /**
             * 缓存目录
             */
            'runtime_path' => '',
            'cache_path' => '', // 默认缓存组件缓存目录
            'logcache_path' => '', // 默认日志目录
            'tablecache_path' => '', // 默认数据库表缓存目录
            'themecache_path' => '', // 默认模板缓存目录
            'optioncache_path' => '', // 默认配置缓存目录
            'optioncache_name' => '', // 默认配置缓存名字
            'i18ncache_path' => '', // 默认国际化缓存目录
            'i18ncache_name' => '', // 默认国际化缓存名字
            'i18njscache_path' => '' 
    ]; // JS默认国际化缓存目录
    
    /**
     * 请求参数
     */
    public $in;
    
    /**
     * 应用程序实例
     *
     * @var app
     */
    private static $arrApps = [ ];
    
    /**
     * 注册控制器
     *
     * @var mixed
     */
    protected $arrControllers = [ ];
    
    /**
     * 注册方法
     *
     * @var mixed
     */
    protected $arrActions = [ ];
    
    /**
     * 构造函数
     *
     * @param array $in            
     * @param boolean $booRun            
     * @return app
     */
    public function __construct($in = [], $bRun = true) {
        
        /**
         * 初始化
         */
        if (! self::getApp ( '~_~' )) {
            /**
             * 项目初始化设置
             */
            if (! isset ( $in ['project_path'] ) || ! is_dir ( $in ['project_path'] )) {
                Q::errorMessage ( "project dir is not exists" );
            }
            $this->project_path = $in ['project_path'];
            $this->app_name = '~_~';
            
            // 初始化
            $this->initProject_ ( $in );
            
            // 注册公共组件命名空间
            Q::import ( 'com', $this->com_path, [ 
                    'ignore' => [ 
                            'i18n',
                            'option',
                            'theme' 
                    ] 
            ] );
            
            // 尝试导入 Composer PSR-4
            Q::importComposer ( $this->vendor_path );
            
            // 注册初始化应用
            self::registerApp ( $this, '~_~' );
            
            // 执行项目初始化
            $this->app ( true );
        }
        
        /**
         * 执行应用
         */
        if (isset ( self::$arrApps [$this->app_name] )) {
            return;
        }
        
        $this->initApp_ ( $in );
        $oApp = self::registerApp ( $this, $this->app_name );
        
        // 注册命名空间
        Q::import ( $this->app_name, $this->app_path . '/' . $this->app_name, [ 
                [ 
                        'i18n',
                        'option',
                        'theme' 
                ] 
        ] );
        
        if ($bRun === true) {
            $this->app ();
        }
        
        unset ( $in );
        return $oApp;
    }
    
    /**
     * APP 入口
     *
     * @param array $in            
     * @param boolean $booRun            
     * @return app
     */
    static public function run($in = [], $bRun = true) {
        return new self ( $in, $bRun );
    }
    
    /**
     * 注册程序实例
     *
     * @param App $app
     *            应用
     * @param string $sAppName
     *            应用名字
     * @return void
     */
    static function registerApp(app $oApp, $sAppName) {
        return self::$arrApps [$sAppName] = $oApp;
    }
    
    /**
     * 取得应用程序实例
     *
     * @return App
     */
    static public function getApp($sAppName = '') {
        if ($sAppName) {
            return isset ( self::$arrApps [$sAppName] ) ? self::$arrApps [$sAppName] : null;
        } else {
            if (self::$arrApps) {
                foreach ( self::$arrApps as $oApp ) {
                    return $oApp;
                }
            }
            return null;
        }
    }
    
    /**
     * 捕捉支持属性参数
     *
     * @param string $sName
     *            支持的项
     * @return 设置项
     */
    public function __get($sName) {
        if (array_key_exists ( $sName, $this->arrProp )) {
            return $this->arrProp [$sName];
        } else {
            Q::throwException ( sprintf ( 'The prop %s is disallowed when you get!', $sName ) );
        }
    }
    
    /**
     * 设置支持属性参数
     *
     * @param string $sName
     *            支持的项
     * @param string $sVal
     *            支持的值、
     * @return 旧值
     */
    public function __set($sName, $sVal) {
        if (array_key_exists ( $sName, $this->arrProp )) {
            $sOld = $this->arrProp [$sName];
            $this->arrProp [$sName] = $sVal;
            return $sOld;
        } else {
            Q::throwException ( sprintf ( 'The prop %s is disallowed when you set!', $sName ) );
        }
    }
    
    /**
     * 执行应用
     *
     * @param bool $bInit
     *            true 表示初始化应用
     * @return void
     */
    public function app($bInit = false) {
        if ($bInit === true) {
            // 移除自动转义和过滤全局变量
            Q::stripslashesMagicquotegpc ();
            if (isset ( $_REQUEST ['GLOBALS'] ) or isset ( $_FILES ['GLOBALS'] )) {
                Q::errorMessage ( 'GLOBALS not allowed!' );
            }
            
            // 加载配置文件
            $this->loadOption_ ();
            
            // 解析系统URL
            url::instance ()->parseUrl ();
            $this->in = $this->checkIn_ ( $_REQUEST );
        } else {
            
            // 加载配置文件
            $this->loadOption_ ();
            
            // 初始化时区和GZIP压缩
            if (function_exists ( 'date_default_timezone_set' )) {
                date_default_timezone_set ( $GLOBALS ['option'] ['time_zone'] );
            }
            if ($GLOBALS ['option'] ['start_gzip'] && function_exists ( 'gz_handler' )) {
                ob_start ( 'gz_handler' );
            } else {
                ob_start ();
            }
            
            // 检查语言包和模板以及定义系统常量
            $this->initView_ ();
            if ($GLOBALS ['option'] ['i18n_on']) {
                $this->initI18n_ ();
            }
            
            // 执行控制器
            $this->controller ();
        }
        
        return;
    }
    
    /**
     * 应用执行控制器
     *
     * @param string $sAction            
     * @param string $sController            
     * @return void
     */
    public function controller($sController = '', $sAction = '') {
        ! $sController && $sController = $this->controller_name;
        ! $sAction && $sAction = $this->action_name;
        
        // 是否已经注册过 action
        if (! $this->hasAction ( $sController, $sAction )) {
            // 判断是否存在已注册的控制器
            if (($mixModule = $this->getController ( $sController ))) {
                switch (true) {
                    // 判断是否为回调
                    case Q::varType ( $mixModule, 'callback' ) :
                        $this->registerAction ( $sController, $sAction, $mixModule );
                        break;
                    
                    // 如果为方法则注册为方法
                    case Q::isKindOf ( $mixModule, 'Q\base\action' ) :
                        $this->registerAction ( $sController, $sAction, [ 
                                $mixModule,
                                'run' 
                        ] );
                        break;
                    
                    // 如果为控制器实例，注册为回调
                    case Q::isKindOf ( $mixModule, 'Q\base\controller' ) :
                    // 实例回调
                    case Q::varType ( $mixModule, 'object' ) :
                    // 静态类回调
                    case Q::varType ( $mixModule, 'string' ) && Q::varType ( [ 
                            $mixModule,
                            $sAction 
                    ], 'callback' ) :
                        $this->registerAction ( $sController, $sAction, [ 
                                $mixModule,
                                $sAction 
                        ] );
                        break;
                    
                    // 数组支持,方法名即数组的键值,注册方法
                    case Q::varType ( $mixModule, 'array' ) :
                        if (isset ( $mixModule [$sAction] )) {
                            $this->registerAction ( $sController, $sAction, $mixModule [$sAction] );
                        } else {
                            Q::throwException ( sprintf ( '数组控制器不存在 %s 方法键值', $sAction ) );
                        }
                        break;
                    
                    // 简单数据直接输出
                    case Q::isThese ( $mixModule, [ 
                            'string',
                            'integer',
                            'int',
                            'float',
                            'boolean',
                            'bool',
                            'num',
                            'numeric',
                            'null' 
                    ] ) :
                        $this->registerAction ( $sController, $sAction, $mixModule );
                        break;
                    
                    default :
                        Q::throwException ( sprintf ( '注册的控制器类型 %s 不受支持', $sController ) );
                        break;
                }
            } else {
                // 尝试读取默认控制器
                $sModuleClass = '\\' . $this->app_name . '\\controller\\' . $sController;
                if (Q::classExists ( $sModuleClass, false, true )) {
                    $oModule = new $sModuleClass ( $this, $this->in );
                    
                    // 注册控制器
                    $this->registerController ( $sController, $oModule );
                    
                    // 注册方法
                    $this->registerAction ( $sController, $sAction, [ 
                            $oModule,
                            $sAction 
                    ] );
                } else {
                    // 默认控制器不存在，尝试直接读取方法
                    $sActionClass = '\\' . $this->app_name . '\\controller\\' . $sController . '\\' . $sAction;
                    if (Q::classExists ( $sActionClass, false, true )) {
                        // 注册控制器
                        $this->registerController ( $sController, new controller ( $this, $this->in ) );
                        
                        $oAction = new $sActionClass ( $this, $this->in );
                        if (Q::isKindOf ( $oAction, 'Q\base\action' )) {
                            // 注册方法
                            $this->registerAction ( $sController, $sAction, [ 
                                    $oAction,
                                    'run' 
                            ] );
                        } else {
                            Q::throwException ( Q::i18n ( '方法 %s 必须为  Q\base\action 实例', $sAction ) );
                        }
                    }
                }
            }
        }
        
        // 执行方法
        $this->action ( $sController, $sAction );
    }
    
    /**
     * 应用执行方法
     *
     * @param string $sAction            
     * @param string $sController            
     * @return void
     */
    public function action($sController = '', $sAction = '') {
        ! $sController && $sController = $this->controller_name;
        ! $sAction && $sAction = $this->action_name;
        
        $mixAction = $this->getAction ( $sController, $sAction );
        
        if ($mixAction !== null) {
            switch (true) {
                // 如果为控制器实例，注册为回调
                case Q::varType ( $mixAction, 'array' ) && isset ( $mixAction [0] ) && Q::isKindOf ( $mixAction [0], 'Q\base\controller' ) :
                    try {
                        if (Q::hasPublicMethod ( $mixAction [0], $mixAction [1] )) {
                            // 执行控制器公用初始化函数
                            if (method_exists ( $mixAction [0], '__init' )) {
                                call_user_func_array ( [ 
                                        $mixAction [0],
                                        '__init' 
                                ], $this->filterArgs_ ( $this->in ) );
                            }
                            
                            call_user_func_array ( [ 
                                    $mixAction [0],
                                    $mixAction [1] 
                            ], $this->filterArgs_ ( $this->in ) );
                        } else {
                            Q::throwException ( Q::i18n ( '控制器 %s 的方法 %s 不存在', $sController, $sAction ) );
                        }
                    } catch ( \ReflectionException $oE ) {
                        $mixAction [0]->__call ( $sAction, $this->filterArgs_ ( $this->in ) );
                    }
                    break;
                
                // 判断是否为回调
                case Q::varType ( $mixAction, 'callback' ) :
                    call_user_func_array ( $mixAction, [ 
                            $this,
                            $this->in 
                    ] );
                    break;
                
                // 如果为方法则注册为方法
                case Q::isKindOf ( $mixAction, 'Q\base\action' ) :
                case Q::varType ( $mixAction, 'object' ) :
                    if (method_exists ( $mixAction, 'run' )) {
                        call_user_func_array ( [ 
                                $mixAction,
                                'run' 
                        ], [ 
                                $this,
                                $this->in 
                        ] );
                    } else {
                        Q::throwException ( '方法对象不存在执行入口  run' );
                    }
                    break;
                
                // 静态类回调
                // 数组支持,方法名即数组的键值,注册方法
                case Q::varType ( $mixAction, 'array' ) :
                    echo Q::jsonEncode ( $mixAction );
                    break;
                
                // 简单数据直接输出
                case Q::isThese ( $mixAction, [ 
                        'string',
                        'integer',
                        'int',
                        'float',
                        'boolean',
                        'bool',
                        'num',
                        'numeric',
                        'null' 
                ] ) :
                    echo $mixAction;
                    break;
                
                default :
                    Q::throwException ( sprintf ( '注册的方法类型 %s 不受支持', $sAction ) );
                    break;
            }
        } else {
            Q::throwException ( sprintf ( '方法 %s 未注册', $sAction ) );
        }
    }
    
    /**
     * 获取控制器
     *
     * @param string $sControllerName            
     * @return 注册的控制器
     */
    public function getController($sControllerName) {
        return isset ( $this->arrControllers [$sControllerName] ) ? $this->arrControllers [$sControllerName] : null;
    }
    
    /**
     * 是否存在控制器
     *
     * @param string $sControllerName            
     * @return boolean
     */
    public function hasController($sControllerName) {
        return isset ( $this->arrControllers [$sControllerName] ) ? true : false;
    }
    
    /**
     * 注册控制器
     * 注册不检查，执行检查
     *
     * @param mixed $Controller            
     * @return 注册的控制器
     */
    public function registerController($sControllerName, $Controller) {
        return $this->arrControllers [$sControllerName] = $Controller;
    }
    
    /**
     * 获取方法
     *
     * @param string $sActionName            
     * @return 注册的方法
     */
    public function getAction($sControllerName, $sActionName) {
        return isset ( $this->arrActions [$sControllerName] [$sActionName] ) ? $this->arrActions [$sControllerName] [$sActionName] : null;
    }
    
    /**
     * 是否存在方法
     *
     * @param string $sControllerName
     *            控制器
     * @param string $sActionName
     *            方法
     *            return boolean
     */
    public function hasAction($sControllerName, $sActionName) {
        return isset ( $this->arrActions [$sControllerName] [$sActionName] ) ? true : false;
    }
    
    /**
     * 注册方法
     * 注册不检查，执行检查
     *
     * @param string $sControllerName
     *            控制器
     * @param string $sActionName
     *            方法
     * @param mixed $action
     *            待注册的方法
     *            return 注册的方法
     */
    public function registerAction($sControllerName, $sActionName, $action) {
        return $this->arrActions [$sControllerName] [$sActionName] = $action;
    }
    
    /**
     * 载入配置文件
     *
     * @return void
     */
    protected function loadOption_() {
        $sOptionCache = $this->optioncache_path . '/' . $this->optioncache_name . '.php';
        
        // 开发模式不用读取缓存
        if (Q_DEVELOPMENT !== 'develop' && is_file ( $sOptionCache )) {
            $GLOBALS ['option'] = Q::option ( ( array ) (include $sOptionCache) );
        } else {
            
            // 读取系统默认配置，并写入默认配置项
            $arrOption = ( array ) (include Q_PATH . '/resource/option/default.php');
            
            // 读取公共缓存和项目配置
            $arrOptionDir = [ 
                    $this->appoption_path 
            ];
            if (is_dir ( $this->com_path . '/option' )) {
                array_unshift ( $arrOptionDir, $this->com_path . '/option' );
            }
            foreach ( $arrOptionDir as $sDir ) {
                // 合并数据，项目配置优先于系统惯性配置
                if (is_file ( $sDir . '/' . $this->appoption_name . '.php' )) {
                    $arrOption = array_merge ( $arrOption, ( array ) (include $sDir . '/' . $this->appoption_name . '.php') );
                }
                
                // 读取扩展配置文件，扩展配置优先于项目配置
                $arrOption ['option_extend'] .= ',' . $arrOption ['option_system_extend']; // 默认加载
                foreach ( array_filter ( array_unique ( explode ( ',', $arrOption ['option_extend'] ) ) ) as $sVal ) {
                    if (is_file ( $sDir . '/' . $sVal . '.php' )) {
                        $arrOption = array_merge ( $arrOption, ( array ) (include $sDir . '/' . $sVal . '.php') );
                    }
                }
            }
            
            if (! is_dir ( $this->optioncache_path )) {
                Q::makeDir ( $this->optioncache_path );
            }
            
            // 缓存所有应用名字
            $arrOption ['~apps~'] = Q::listDir ( $this->app_path );
            
            if (! file_put_contents ( $sOptionCache, "<?php\n /* Option Cache */ \n return " . var_export ( $arrOption, true ) . "\n?>" )) {
                Q::errorMessage ( sprintf ( 'Dir %s Do not have permission.', $this->optioncache_path ) );
            }
            
            $GLOBALS ['option'] = Q::option ( $arrOption );
            unset ( $arrOption, $sAppOptionPath );
        }
    }
    
    /**
     * 初始化视图
     *
     * @return void
     */
    protected function initView_() {
        if (! $GLOBALS ['option'] ['theme_switch']) {
            $sThemeSet = $GLOBALS ['option'] ['theme_default'];
        } else {
            if ($GLOBALS ['option'] ['cookie_langtheme_app'] === TRUE) {
                $sCookieName = $this->app_name . '_theme';
            } else {
                $sCookieName = 'theme';
            }
            
            if (isset ( $_GET ['~theme~'] )) {
                $sThemeSet = $_GET ['~theme~'];
                Q::cookie ( $sCookieName, $sThemeSet );
            } else {
                if (Q::cookie ( $sCookieName )) {
                    $sThemeSet = Q::cookie ( $sCookieName );
                } else {
                    $sThemeSet = $GLOBALS ['option'] ['theme_default'];
                }
            }
        }
        
        // 设置应用主题名字
        $this->apptheme_name = $sThemeSet;
        view::setThemeDir ( $this->apptheme_path . '/' . $sThemeSet );
        if ($this->appthemebackup_path) {
            view::setThemeDefault ( $this->appthemebackup_path . '/' . $sThemeSet );
        }
    }
    
    /**
     * 初始化国际语言包设置
     *
     * @return void
     */
    protected function initI18n_() {
        if (! $GLOBALS ['option'] ['i18n_switch']) {
            $sI18nSet = $GLOBALS ['option'] ['i18n_default'];
            i18n::setContext ( $sI18nSet );
        } else {
            if ($GLOBALS ['option'] ['cookie_langtheme_app'] === TRUE) {
                $sCookieName = $this->app_name . '_i18n';
            } else {
                $sCookieName = 'i18n';
            }
            i18n::setCookieName ( $sCookieName );
            i18n::setDefaultContext ( $GLOBALS ['option'] ['i18n_default'] );
            $sI18nSet = i18n::parseContext ();
        }
        
        // 判断是否为默认主题，非默认主题载入语言包
        if ($GLOBALS ['option'] ['i18n_develop'] == $sI18nSet) {
            return;
        }
        
        $this->appi18n_name = $sI18nSet;
        Q::$booI18nOn = TRUE; // 开启语言
        $sCacheFile = '/' . $sI18nSet . '/' . $this->i18ncache_name . '.php';
        
        // 开发模式不用读取缓存
        if (Q_DEVELOPMENT !== 'develop' && is_file ( $this->i18ncache_path . $sCacheFile ) && is_file ( $this->i18njscache_path . $sCacheFile )) {
            i18n::addI18n ( $sI18nSet, ( array ) (include $this->i18ncache_path . $sCacheFile) );
        } else {
            
            /**
             * 分析语言包
             */
            $arrAllI18nDir = [ 
                    Q_PATH . '/resource/i18n/' . $sI18nSet, // 系统语言包
                    $this->com_path . '/' . $sI18nSet, // com语言包
                    $this->appi18n_path . '/' . $sI18nSet 
            ]; // 应用语言包
               
            // 扩展语言包
            if ($this->appi18nextend_path) {
                if (is_array ( $this->appi18nextend_path )) {
                    $arrAllI18nDir = array_merge ( $arrAllI18nDir, $this->appi18nextend_path );
                } else {
                    $arrAllI18nDir [] = $this->appi18nextend_path;
                }
            }
            $arrFiles = tool::findPoFile ( $arrAllI18nDir );
            
            /**
             * 保存到缓存文件
             */
            i18n::addI18n ( $sI18nSet, tool::saveToPhp ( $arrFiles ['php'], $this->i18ncache_path . $sCacheFile ) );
            tool::saveToJs ( $arrFiles ['js'], $this->i18njscache_path . $sCacheFile, $sI18nSet );
            
            unset ( $arrFiles, $arrAllI18nDir, $sCacheFile );
        }
    }
    
    /**
     * 初始化项目
     *
     * @param array $in
     *            参数
     * @return void
     */
    protected function initProject_($in) {
        
        /**
         * 项目基础目录
         */
        $arrDefault = [ 
                'app_path' => 'app', // app
                'com_path' => 'com', // com
                'runtime_path' => '~@~', // runtime
                'apppublic_path' => 'www/public', // public
                'vendor_path' => 'lib/vendor' 
        ]; // vendor

        
        foreach ( $arrDefault as $sKey => $sPath ) {
            ! isset ( $in [$sKey] ) && $in [$sKey] = $this->project_path . '/' . $sPath;
        }
        
        /**
         * 项目基础应用参数
         */
        $sAppName = $this->app_name;
        $sAppPath = $in ['app_path'] . '/' . $sAppName;
        
        $arrDefault = [ 
                
                /**
                 * 缓存目录
                 */
                'cache_path' => $in ['runtime_path'] . '/cache', // 默认缓存组件缓存目录
                'optioncache_path' => $in ['runtime_path'] . '/option', // 默认配置缓存目录
                'optioncache_name' => $sAppName, // 默认缓存配置名字
                
                /**
                 * 应用其他目录
                 */
                'appoption_path' => $sAppPath . '/option', // 默认配置目录
                'appoption_name' => 'default' 
        ]; // 默认配置名字
        
        $this->arrProp = array_merge ( $this->arrProp, $arrDefault, $in );
        
        unset ( $in, $arrDefault );
    }
    
    /**
     * 初始化应用
     *
     * @param array $in
     *            参数
     * @return void
     */
    protected function initApp_($in) {
        $sAppName = $this->app_name;
        $sAppPath = $this->app_path . '/' . $sAppName;
        $sRuntime = $this->runtime_path;
        
        $arrDefault = [ 
                
                /**
                 * 缓存目录
                 */
                'cache_path' => $sRuntime . '/cache', // 默认缓存组件缓存目录
                'logcache_path' => $sRuntime . '/log', // 默认日志目录
                'tablecache_path' => $sRuntime . '/table', // 默认数据库表缓存目录
                'themecache_path' => $sRuntime . '/theme/' . $sAppName, // 默认模板缓存目录
                'optioncache_path' => $sRuntime . '/option', // 默认配置缓存目录
                'optioncache_name' => $sAppName, // 默认缓存配置名字
                'i18ncache_path' => $sRuntime . '/i18n', // 默认语言包缓存目录
                'i18ncache_name' => $sAppName, // 默认缓存配置名字
                'i18njscache_path' => $this->apppublic_path . '/js/i18n', // 默认 JS 语言包缓存目录
                
                /**
                 * 应用其他目录
                 */
                'appoption_path' => $sAppPath . '/option', // 默认配置目录
                'appoption_name' => 'default', // 默认配置名字
                'apptheme_path' => $sAppPath . '/theme', // 默认主题目录
                'appthemebackup_path' => '', // 备用主题目录
                'appi18n_path' => $sAppPath . '/i18n' 
        ]; // 默认语言目录
        
        $this->arrProp = array_merge ( $this->arrProp, $arrDefault, $in );
        unset ( $in, $arrDefault );
    }
    
    /**
     * 检查 URL 非法请求
     *
     * @param $in return
     *            void
     */
    protected function checkIn_($in) {
        return $in;
    }
    
    /**
     * 过滤掉系统控制器等参数
     *
     * @param array $arrArgs            
     * @return
     *
     */
    protected function filterArgs_($arrArgs) {
        unset ( $arrArgs ['app'], $arrArgs ['c'], $arrArgs ['a'] );
        return $arrArgs;
    }
    
    /**
     * 拦截匿名注册控制器方法
     *
     * @param 方法名 $sMethod            
     * @param 参数 $arrArgs            
     * @return boolean
     */
    public function __call($sMethod, $arrArgs) {
        if (! $this->hasController ( 'query_default' )) {
            $this->registerController ( 'query_default', new controller ( $this, $this->in ) );
        }
        return call_user_func_array ( [ 
                $this->getController ( 'query_default' ),
                $sMethod 
        ], $arrArgs );
    }
}
