<?php
/*
 * [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
 * ©2010-2017 http://queryphp.com All rights reserved.
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @version $$
 * @date 2016.11.18
 * @since 1.0
 */
namespace Q\mvc;

use Q\router\router, Q\i18n\i18n, Q\i18n\tool;

/**
 * 应用程序对象
 *
 * @author Xiangmin Liu
 */
class app {
    
    /**
     * 应用程序属性
     */
    protected $arrProp = [ 
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
            'url_enter' => '', // php 文件所在 url 地址如 http://myapp.com/index.php
            'url_root' => '', // 网站 root http://myapp.com
            'url_public' => '',
            
            /**
             * 缓存目录
             */
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
     * 当前项目
     *
     * @var Q\mvc\project
     */
    protected $objProject = null;
    
    /**
     * 构造函数
     *
     * @param array $in            
     * @param boolean $booRun            
     * @return app
     */
    public function __construct($objProject, $sApp, $in = []) {
        // 带入项目
        $this->objProject = $objProject;
        
        // 公共 url 地址
        $this->url_enter = $this->objProject->url_enter;
        $this->url_root = $this->objProject->url_root;
        $this->url_public = $this->objProject->url_public;
        
        // 初始化应用
        $this->app_name = $sApp;
        $this->initApp_ ( $in );
        
        // 注册命名空间
        \Q::import ( $this->app_name, $this->objProject->app_path . '/' . $this->app_name, [ 
                [ 
                        'i18n',
                        'option',
                        'theme' 
                ] 
        ] );
        
        // 加载配置文件
        $this->loadOption_ ();
        
        unset ( $in );
        return $this;
    }
    
    /**
     * APP 入口
     *
     * @param array $in            
     * @param boolean $booRun            
     * @return app
     */
    static public function run($objProject, $sApp, $in = [], $bRun = true) {
        return new self ( $objProject, $sApp, $in, $bRun );
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
            \Q::throwException ( sprintf ( 'The prop %s is disallowed when you get!', $sName ) );
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
            \Q::throwException ( sprintf ( 'The prop %s is disallowed when you set!', $sName ) );
        }
    }
    
    /**
     * 执行应用
     *
     * @return void
     */
    public function app() {
        // 初始化时区和GZIP压缩
        if (function_exists ( 'date_defaault_timezone_set' )) {
            date_default_timezone_set ( $GLOBALS ['~@option'] ['time_zone'] );
        }
        if ($GLOBALS ['~@option'] ['start_gzip'] && function_exists ( 'gz_handler' )) {
            ob_start ( 'gz_handler' );
        } else {
            ob_start ();
        }
        
        // 载入 app 引导文件
        if (is_file ( ($strBootstrap = $this->objProject->app_path . '/' . $this->app_name . '/bootstrap.php') )) {
            require $strBootstrap;
        }
        
        // 检查语言包和模板
        $this->initView_ ();
        if ($GLOBALS ['~@option'] ['i18n_on']) {
            $this->initI18n_ ();
        }
        
        // 执行控制器
        $this->in = project::$in;
        $this->controller_name = $this->in [\Q\mvc\project::ARGS_CONTROLLER];
        $this->action_name = $this->in [\Q\mvc\project::ARGS_ACTION];
        $this->controller ();
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
                    case \Q::varType ( $mixModule, 'callback' ) :
                        $this->registerAction ( $sController, $sAction, $mixModule );
                        break;
                    
                    // 如果为方法则注册为方法
                    case \Q::isKindOf ( $mixModule, 'Q\mvc\action' ) :
                        $this->registerAction ( $sController, $sAction, [ 
                                $mixModule,
                                'run' 
                        ] );
                        break;
                    
                    // 如果为控制器实例，注册为回调
                    case \Q::isKindOf ( $mixModule, 'Q\mvc\controller' ) :
                    // 实例回调
                    case \Q::varType ( $mixModule, 'object' ) :
                    // 静态类回调
                    case \Q::varType ( $mixModule, 'string' ) && \Q::varType ( [ 
                            $mixModule,
                            $sAction 
                    ], 'callback' ) :
                        $this->registerAction ( $sController, $sAction, [ 
                                $mixModule,
                                $sAction 
                        ] );
                        break;
                    
                    // 数组支持,方法名即数组的键值,注册方法
                    case \Q::varType ( $mixModule, 'array' ) :
                        if (isset ( $mixModule [$sAction] )) {
                            $this->registerAction ( $sController, $sAction, $mixModule [$sAction] );
                        } else {
                            \Q::throwException ( sprintf ( '数组控制器不存在 %s 方法键值', $sAction ) );
                        }
                        break;
                    
                    // 简单数据直接输出
                    case \Q::isThese ( $mixModule, [ 
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
                        \Q::throwException ( sprintf ( '注册的控制器类型 %s 不受支持', $sController ) );
                        break;
                }
            } else {
                // 尝试读取默认控制器
                $sModuleClass = '\\' . $this->app_name . '\\controller\\' . $sController;
                if (\Q::classExists ( $sModuleClass, false, true )) {
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
                    if (\Q::classExists ( $sActionClass, false, true )) {
                        // 注册控制器
                        $this->registerController ( $sController, new controller ( $this, $this->in ) );
                        
                        $oAction = new $sActionClass ( $this, $this->in );
                        if (\Q::isKindOf ( $oAction, 'Q\mvc\action' )) {
                            // 注册方法
                            $this->registerAction ( $sController, $sAction, [ 
                                    $oAction,
                                    'run' 
                            ] );
                        } else {
                            \Q::throwException ( \Q::i18n ( '方法 %s 必须为  Q\base\action 实例', $sAction ) );
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
                case \Q::varType ( $mixAction, 'array' ) && isset ( $mixAction [0] ) && \Q::isKindOf ( $mixAction [0], 'Q\mvc\controller' ) :
                    try {
                        if (\Q::hasPublicMethod ( $mixAction [0], $mixAction [1] )) {
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
                            \Q::throwException ( \Q::i18n ( '控制器 %s 的方法 %s 不存在', $sController, $sAction ) );
                        }
                    } catch ( \ReflectionException $oE ) {
                        $mixAction [0]->__call ( $sAction, $this->filterArgs_ ( $this->in ) );
                    }
                    break;
                
                // 判断是否为回调
                case \Q::varType ( $mixAction, 'callback' ) :
                    call_user_func_array ( $mixAction, [ 
                            $this,
                            $this->in 
                    ] );
                    break;
                
                // 如果为方法则注册为方法
                case \Q::isKindOf ( $mixAction, 'Q\mvc\action' ) :
                case \Q::varType ( $mixAction, 'object' ) :
                    if (method_exists ( $mixAction, 'run' )) {
                        call_user_func_array ( [ 
                                $mixAction,
                                'run' 
                        ], [ 
                                $this,
                                $this->in 
                        ] );
                    } else {
                        \Q::throwException ( '方法对象不存在执行入口  run' );
                    }
                    break;
                
                // 静态类回调
                // 数组支持,方法名即数组的键值,注册方法
                case \Q::varType ( $mixAction, 'array' ) :
                    echo \Q::jsonEncode ( $mixAction );
                    break;
                
                // 简单数据直接输出
                case \Q::isThese ( $mixAction, [ 
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
                    \Q::throwException ( \Q::i18n ( '注册的方法类型 %s 不受支持', $sAction ) );
                    break;
            }
        } else {
            \Q::throwException ( \Q::i18n ( '控制器 %s 的方法 %s 未注册', $sController, $sAction ) );
        }
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
    
    /**
     * 获取控制器
     *
     * @param string $sControllerName            
     * @return 注册的控制器
     */
    protected function getController($sControllerName) {
        $mixController = router::getBind ( $this->packControllerAndAction_ ( $sControllerName ) );
        if ($mixController !== null) {
            return $mixController;
        }
        return router::getBind ( $sControllerName );
    }
    
    /**
     * 是否存在控制器
     *
     * @param string $sControllerName            
     * @return boolean
     */
    protected function hasController($sControllerName) {
        $booHasController = router::hasBind ( $this->packControllerAndAction_ ( $sControllerName ) );
        if ($booHasController === false) {
            $booHasController = router::hasBind ( $sControllerName );
        }
        return $booHasController;
    }
    
    /**
     * 注册控制器
     * 注册不检查，执行检查
     *
     * @param mixed $mixController            
     * @return 注册的控制器
     */
    protected function registerController($sControllerName, $mixController) {
        router::bind ( $this->packControllerAndAction_ ( $sControllerName ), $mixController );
    }
    
    /**
     * 获取方法
     *
     * @param string $sActionName            
     * @return 注册的方法
     */
    protected function getAction($sControllerName, $sActionName) {
        $mixAction = router::getBind ( $this->packControllerAndAction_ ( $sControllerName, $sActionName ) );
        if ($mixAction !== null) {
            return $mixAction;
        }
        return router::getBind ( $sControllerName . '/' . $sActionName );
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
    protected function hasAction($sControllerName, $sActionName) {
        $booHasAction = router::hasBind ( $this->packControllerAndAction_ ( $sControllerName, $sActionName ) );
        if ($booHasAction === false) {
            $booHasAction = router::hasBind ( $sControllerName . '/' . $sActionName );
        }
        return $booHasAction;
    }
    
    /**
     * 注册方法
     * 注册不检查，执行检查
     *
     * @param string $sControllerName
     *            控制器
     * @param string $sActionName
     *            方法
     * @param mixed $mixAction
     *            待注册的方法
     *            return 注册的方法
     */
    protected function registerAction($sControllerName, $sActionName, $mixAction) {
        return router::bind ( $this->packControllerAndAction_ ( $sControllerName, $sActionName ), $mixAction );
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
            $GLOBALS ['~@option'] = \Q::option ( ( array ) (include $sOptionCache) );
            if ($this->app_name == \Q\mvc\project::INIT_APP && $arrOption ['url_router_cache']) {
                if (! empty ( $arrOption ['url_router_cache'] )) {
                    router::cache ( $arrOption ['url_router_cache'] );
                }
            }
        } else {
            // 读取系统默认配置，并写入默认配置项
            $arrOption = ( array ) (include Q_PATH . '/~@~/option/default.php');
            
            // 路由和配置扩展文件
            $arrRouterExtend = array_filter ( array_unique ( explode ( ',', 'router' . ($arrOption ['url_router_extend'] ? ',' . $arrOption ['url_router_extend'] : '') ) ) );
            $arrOptionExtend = array_filter ( array_unique ( explode ( ',', $arrOption ['option_extend'] . ($arrOption ['option_system_extend'] ? ',' . $arrOption ['option_system_extend'] : '') ) ) );
            
            if (! isset ( $arrOption ['~router~'] )) {
                $arrOption ['~router~'] = [ ];
            }
            
            // 读取公共缓存和项目配置
            $arrOptionDir = [ 
                    $this->appoption_path 
            ];
            
            if (is_dir ( $this->objProject->com_path . '/option' )) {
                array_unshift ( $arrOptionDir, $this->objProject->com_path . '/option' );
            }
            
            foreach ( $arrOptionDir as $sDir ) {
                // 合并数据，项目配置优先于系统惯性配置
                if (is_file ( $sDir . '/' . $this->appoption_name . '.php' )) {
                    $arrOption = array_merge ( $arrOption, ( array ) (include $sDir . '/' . $this->appoption_name . '.php') );
                }
                
                // 读取扩展配置文件，扩展配置优先于项目配置
                foreach ( $arrOptionExtend as $sVal ) {
                    if (! in_array ( $sVal, $arrRouterExtend ) && is_file ( $sDir . '/' . $sVal . '.php' )) {
                        $arrOption = array_merge ( $arrOption, ( array ) (include $sDir . '/' . $sVal . '.php') );
                    }
                }
            }
            
            if (! is_dir ( $this->optioncache_path )) {
                \Q::makeDir ( $this->optioncache_path );
            }
            
            // 缓存所有应用名字
            $arrOption ['~apps~'] = \Q::listDir ( $this->objProject->app_path );
            if ($this->app_name == \Q\mvc\project::INIT_APP) {
                foreach ( $arrOption ['~apps~'] as $strApp ) {
                    if ($strApp == \Q\mvc\project::INIT_APP) {
                        continue;
                    }
                    $arrOptionDir [] = str_replace ( '/' . \Q\mvc\project::INIT_APP . '/', '/' . $strApp . '/', $this->appoption_path );
                }
                
                $arrOption ['url_router_cache'] = [ ];
                
                foreach ( $arrOptionDir as $sDir ) {
                    foreach ( $arrRouterExtend as $sVal ) {
                        if (is_file ( $sDir . '/' . $sVal . '.php' )) {
                            $arrRouter = include $sDir . '/' . $sVal . '.php';
                            if ($arrRouter === 1) {
                                continue;
                            }
                            
                            $arrOption ['url_router_cache'] = $this->mergeRouter_ ( $arrOption ['url_router_cache'], ( array ) (include $sDir . '/' . $sVal . '.php') );
                        }
                    }
                }
                
                if (! empty ( $arrOption ['url_router_cache'] )) {
                    router::cache ( $arrOption ['url_router_cache'] );
                }
            }
            
            if (! file_put_contents ( $sOptionCache, "<?php\n /* option cache */ \n return " . var_export ( $arrOption, true ) . "\n?>" )) {
                \Q::errorMessage ( sprintf ( 'Dir %s Do not have permission.', $this->optioncache_path ) );
            }
            
            $GLOBALS ['~@option'] = \Q::option ( $arrOption );
            unset ( $arrOption, $sAppOptionPath, $arrOptionDir, $arrOptionExtend, $arrRouterExtend );
        }
    }
    
    /**
     * 初始化视图
     *
     * @return void
     */
    protected function initView_() {
        if (! $GLOBALS ['~@option'] ['theme_switch']) {
            $sThemeSet = $GLOBALS ['~@option'] ['theme_default'];
        } else {
            if ($GLOBALS ['~@option'] ['cookie_langtheme_app'] === TRUE) {
                $sCookieName = $this->app_name . '_theme';
            } else {
                $sCookieName = 'theme';
            }
            
            if (isset ( $_GET [\Q\mvc\project::ARGS_THEME] )) {
                $sThemeSet = $_GET [\Q\mvc\project::ARGS_THEME];
                \Q::cookie ( $sCookieName, $sThemeSet );
            } else {
                if (Q::cookie ( $sCookieName )) {
                    $sThemeSet = \Q::cookie ( $sCookieName );
                } else {
                    $sThemeSet = $GLOBALS ['~@option'] ['theme_default'];
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
        if (! $GLOBALS ['~@option'] ['i18n_switch']) {
            $sI18nSet = $GLOBALS ['~@option'] ['i18n_default'];
            i18n::setContext ( $sI18nSet );
        } else {
            if ($GLOBALS ['~@option'] ['cookie_langtheme_app'] === TRUE) {
                $sCookieName = $this->app_name . '_i18n';
            } else {
                $sCookieName = 'i18n';
            }
            i18n::setCookieName ( $sCookieName );
            i18n::setDefaultContext ( $GLOBALS ['~@option'] ['i18n_default'] );
            $sI18nSet = i18n::parseContext ();
        }
        
        // 判断是否为默认主题，非默认主题载入语言包
        if ($GLOBALS ['~@option'] ['i18n_develop'] == $sI18nSet) {
            return;
        }
        
        $this->appi18n_name = $sI18nSet;
        \Q::$booI18nOn = TRUE; // 开启语言
        $sCacheFile = '/' . $sI18nSet . '/' . $this->i18ncache_name . '.php';
        
        // 开发模式不用读取缓存
        if (Q_DEVELOPMENT !== 'develop' && is_file ( $this->i18ncache_path . $sCacheFile ) && is_file ( $this->i18njscache_path . $sCacheFile )) {
            i18n::addI18n ( $sI18nSet, ( array ) (include $this->i18ncache_path . $sCacheFile) );
        } else {
            
            /**
             * 分析语言包
             */
            $arrAllI18nDir = [ 
                    Q_PATH . '/~@~/i18n/' . $sI18nSet, // 系统语言包
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
     * 初始化应用
     *
     * @param array $in
     *            参数
     * @return void
     */
    protected function initApp_($in) {
        $sAppName = $this->app_name;
        $sAppPath = $this->objProject->app_path . '/' . $sAppName;
        $sRuntime = $this->objProject->runtime_path;
        
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
                'i18njscache_path' => $this->objProject->apppublic_path . '/js/i18n', // 默认 JS 语言包缓存目录
                
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
     * 过滤掉系统控制器等参数
     *
     * @param array $arrArgs            
     * @return
     *
     */
    protected function filterArgs_($arrArgs) {
        unset ( $arrArgs [\Q\mvc\project::ARGS_APP], $arrArgs [\Q\mvc\project::ARGS_CONTROLLER], $arrArgs [\Q\mvc\project::ARGS_ACTION] );
        return $arrArgs;
    }
    
    /**
     * 装配注册节点
     *
     * @param string $strController            
     * @param string $strAction            
     * @return
     *
     */
    protected function packControllerAndAction_($strController, $strAction = '') {
        return $this->app_name . '://' . $strController . ($strAction ? '/' . $strAction : '');
    }
    
    /**
     * 合并 router 参数
     *
     * @param array $arrRouter            
     * @param array $arrNewRouter            
     * @return array
     */
    protected function mergeRouter_(array $arrRouter, array $arrNewRouter) {
        // 合并域名参数
        if (! empty ( $arrNewRouter ['~domains~'] ) && is_array ( $arrNewRouter ['~domains~'] )) {
            if (! isset ( $arrRouter ['~domains~'] )) {
                $arrRouter ['~domains~'] = [ ];
            }
            $arrMergeRouters = array_merge ( $arrRouter ['~domains~'], $arrNewRouter ['~domains~'] );
            $arrRouter = array_merge ( $arrRouter, $arrNewRouter );
            $arrRouter ['~domains~'] = $arrMergeRouters;
        } else {
            $arrRouter = array_merge ( $arrRouter, $arrNewRouter );
        }
        return $arrRouter;
    }
}
