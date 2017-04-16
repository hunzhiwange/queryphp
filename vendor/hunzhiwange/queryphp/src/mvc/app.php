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
namespace Q\mvc;

use Q\router\router;
use Q\i18n\i18n;
use Q\i18n\tool;

/**
 * 应用程序对象
 *
 * @author Xiangmin Liu
 */
class app {
    
    /**
     * 当前项目
     *
     * @var Q\mvc\project
     */
    private $objProject = null;
    
    /**
     * 当前请求
     *
     * @var Q\mvc\request
     */
    private $objRequest = null;
    
    /**
     * 项目配置
     *
     * @var array
     */
    private $arrOption = [ ];
    
    /**
     * 构造函数
     *
     * @param Q\mvc\project $objProject            
     * @param string $sApp            
     * @param array $arrOption            
     * @return app
     */
    public function __construct(project $objProject, $sApp, $arrOption = []) {
        // 带入项目
        $this->objProject = $objProject;
        
        // 初始化应用
        $this->objProject->instance ( 'app_name', $sApp );
        
        // 项目配置
        $this->arrOption = $arrOption;
    }
    
    /**
     * 返回应用实例
     *
     * @param Q\mvc\project $objProject            
     * @param string $sApp            
     * @param array $arrOption            
     * @return \Q\mvc\app
     */
    static public function instance(project $objProject, $sApp, $arrOption = []) {
        return new self ( $objProject, $sApp, $arrOption );
    }
    
    /**
     * 执行应用
     *
     * @return \Q\mvc\app
     */
    public function run() {
        // 初始化应用
        $this->initApp_ ( $this->arrOption );
        
        // 注册命名空间
        \Q::import ( $this->objProject->app_name, $this->objProject->path_application . '/' . $this->objProject->app_name, [ 
                [ 
                        'i18n',
                        'option',
                        'theme' 
                ] 
        ] );
        
        // 加载配置文件
        $this->loadOption_ ();
        
        // 返回自身
        return $this;
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
        if (is_file ( ($strBootstrap = $this->objProject->path_application . '/' . $this->objProject->app_name . '/bootstrap.php') )) {
            require $strBootstrap;
        }
        
        // 检查语言包和模板
        $this->initView_ ();
        if ($GLOBALS ['~@option'] ['i18n_on']) {
            $this->initI18n_ ();
        }
        
        // 执行控制器
        $this->objRequest = $this->objProject->make ( request::class );
        $this->objProject->instance ( 'controller_name', $this->objRequest->controller () );
        $this->objProject->instance ( 'action_name', $this->objRequest->action () );
        $this->controller ();
        
        // 返回自身
        return $this;
    }
    
    /**
     * 应用执行控制器
     *
     * @param string $sAction            
     * @param string $sController            
     * @return void
     */
    public function controller($sController = '', $sAction = '') {
        ! $sController && $sController = $this->objProject->controller_name;
        ! $sAction && $sAction = $this->objProject->action_name;
        
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
                    case \Q::varType ( $mixModule, 'scalar' ) :
                        $this->registerAction ( $sController, $sAction, $mixModule );
                        break;
                    
                    default :
                        \Q::throwException ( sprintf ( '注册的控制器类型 %s 不受支持', $sController ) );
                        break;
                }
            } else {
                // 尝试读取默认控制器
                $sModuleClass = '\\' . $this->objProject->app_name . '\\controller\\' . $sController;
                if (\Q::classExists ( $sModuleClass, false, true )) {
                    // 自动注入
                    if (($objAutoInjection = $this->parseAutoInjection_ ( $sModuleClass, true ))) {
                        $oModule = new $sModuleClass ( $objAutoInjection, $this->objRequest, $this );
                    } else {
                        $oModule = new $sModuleClass ( $this->objRequest, $this );
                    }
                    
                    // 注册控制器
                    $this->registerController ( $sController, $oModule );
                    
                    // 注册方法
                    $this->registerAction ( $sController, $sAction, [ 
                            $oModule,
                            $sAction 
                    ] );
                } else {
                    // 默认控制器不存在，尝试直接读取方法
                    $sActionClass = '\\' . $this->objProject->app_name . '\\controller\\' . $sController . '\\' . $sAction;
                    if (\Q::classExists ( $sActionClass, false, true )) {
                        // 注册控制器
                        $this->registerController ( $sController, new controller ( $this->objRequest, $this ) );
                        
                        // 自动注入
                        if (($objAutoInjection = $this->parseAutoInjection_ ( $sActionClass ))) {
                            $oAction = new $sActionClass ( $objAutoInjection, $this->objRequest, $this );
                        } else {
                            $oAction = new $sActionClass ( $this->objRequest, $this );
                        }
                        
                        if (\Q::isKindOf ( $oAction, 'Q\mvc\action' )) {
                            // 注册方法
                            $this->registerAction ( $sController, $sAction, [ 
                                    $oAction,
                                    'run' 
                            ] );
                        } else {
                            \Q::throwException ( \Q::i18n ( '方法 %s 必须为  Q\mvc\action 实例', $sAction ) );
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
        ! $sController && $sController = $this->objProject->controller_name;
        ! $sAction && $sAction = $this->objProject->action_name;
        
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
                                ], [ 
                                        
                                        $this->objRequest,
                                        $this 
                                ] );
                            }
                            
                            call_user_func_array ( [ 
                                    $mixAction [0],
                                    $mixAction [1] 
                            ], [ 
                                    
                                    $this->objRequest,
                                    $this 
                            ] );
                        } else {
                            \Q::throwException ( \Q::i18n ( '控制器 %s 的方法 %s 不存在', $sController, $sAction ) );
                        }
                    } catch ( \ReflectionException $oE ) {
                        $mixAction [0]->__call ( $sAction, [ 
                                
                                $this->objRequest,
                                $this 
                        ] );
                    }
                    break;
                
                // 判断是否为回调
                case \Q::varType ( $mixAction, 'callback' ) :
                    
                    // 自动注入
                    $arrArgs = [ 
                            
                            $this->objRequest,
                            $this 
                    ];
                    if (($objAutoInjection = $this->parseAutoInjection_ ( $mixAction, false ))) {
                        array_unshift ( $arrArgs, $objAutoInjection );
                    }
                    call_user_func_array ( $mixAction, $arrArgs );
                    break;
                
                // 如果为方法则注册为方法
                case \Q::isKindOf ( $mixAction, 'Q\mvc\action' ) :
                case \Q::varType ( $mixAction, 'object' ) :
                    if (method_exists ( $mixAction, 'run' )) {
                        $calRun = [ 
                                $mixAction,
                                'run' 
                        ];
                        
                        // 自动注入
                        $arrArgs = [ 
                                
                                $this->objRequest,
                                $this 
                        ];
                        if (($objAutoInjection = $this->parseAutoInjection_ ( $calRun, false ))) {
                            array_unshift ( $arrArgs, $objAutoInjection );
                        }
                        
                        call_user_func_array ( $calRun, $arrArgs );
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
                case \Q::varType ( $mixAction, 'scalar' ) :
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
            $this->registerController ( 'query_default', new controller ( $this->objRequest, $this ) );
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
    private function getController($sControllerName) {
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
    private function hasController($sControllerName) {
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
    private function registerController($sControllerName, $mixController) {
        router::bind ( $this->packControllerAndAction_ ( $sControllerName ), $mixController );
    }
    
    /**
     * 获取方法
     *
     * @param string $sActionName            
     * @return 注册的方法
     */
    private function getAction($sControllerName, $sActionName) {
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
     * @return boolean
     */
    private function hasAction($sControllerName, $sActionName) {
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
     * @return 注册的方法
     */
    private function registerAction($sControllerName, $sActionName, $mixAction) {
        return router::bind ( $this->packControllerAndAction_ ( $sControllerName, $sActionName ), $mixAction );
    }
    
    /**
     * 载入配置文件
     *
     * @return void
     */
    private function loadOption_() {
        $sOptionCache = $this->objProject->path_cache_option . '/default.php';
        
        // 开发模式不用读取缓存
        if (Q_DEVELOPMENT !== 'develop' && is_file ( $sOptionCache )) {
            $GLOBALS ['~@option'] = \Q::option ( ( array ) (include $sOptionCache) );
            if ($this->objProject->app_name == \Q\mvc\project::INIT_APP && $arrOption ['url_router_cache']) {
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
                    $this->objProject->path_app_option 
            ];
            
            if (is_dir ( $this->objProject->path_common . '/option' )) {
                array_unshift ( $arrOptionDir, $this->objProject->path_common . '/option' );
            }
            
            foreach ( $arrOptionDir as $sDir ) {
                // 合并数据，项目配置优先于系统惯性配置
                if (is_file ( $sDir . '/default.php' )) {
                    $arrOption = array_merge ( $arrOption, ( array ) (include $sDir . '/default.php') );
                }
                
                // 读取扩展配置文件，扩展配置优先于项目配置
                foreach ( $arrOptionExtend as $sVal ) {
                    if (! in_array ( $sVal, $arrRouterExtend ) && is_file ( $sDir . '/' . $sVal . '.php' )) {
                        $arrOption = array_merge ( $arrOption, ( array ) (include $sDir . '/' . $sVal . '.php') );
                    }
                }
            }
            
            if (! is_dir ( $this->objProject->path_cache_option )) {
                \Q::makeDir ( $this->objProject->path_cache_option );
            }
            
            // 缓存所有应用名字
            $arrOption ['~apps~'] = \Q::listDir ( $this->objProject->path_application );
            if ($this->objProject->app_name == \Q\mvc\project::INIT_APP) {
                foreach ( $arrOption ['~apps~'] as $strApp ) {
                    if ($strApp == \Q\mvc\project::INIT_APP) {
                        continue;
                    }
                    $arrOptionDir [] = str_replace ( '/' . \Q\mvc\project::INIT_APP . '/', '/' . $strApp . '/', $this->objProject->path_app_option );
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
    private function initView_() {
        if (! $GLOBALS ['~@option'] ['theme_switch']) {
            $sThemeSet = $GLOBALS ['~@option'] ['theme_default'];
        } else {
            if ($GLOBALS ['~@option'] ['cookie_langtheme_app'] === TRUE) {
                $sCookieName = $this->objProject->app_name . '_theme';
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
        $this->objProject->instance ( 'name_app_theme', $sThemeSet );
        view::setThemeDir ( $this->objProject->path_app_theme . '/' . $sThemeSet );
        if ($this->objProject->path_app_theme_extend) {
            view::setThemeDefault ( $this->objProject->path_app_theme_extend . '/' . $sThemeSet );
        }
    }
    
    /**
     * 初始化国际语言包设置
     *
     * @return void
     */
    private function initI18n_() {
        if (! $GLOBALS ['~@option'] ['i18n_switch']) {
            $sI18nSet = $GLOBALS ['~@option'] ['i18n_default'];
            i18n::setContext ( $sI18nSet );
        } else {
            if ($GLOBALS ['~@option'] ['cookie_langtheme_app'] === TRUE) {
                $sCookieName = $this->objProject->app_name . '_i18n';
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
        
        $this->objProject->instance ( 'name_app_i18n', $sI18nSet );
        \Q::$booI18nOn = TRUE; // 开启语言
        $sCacheFile = '/' . $sI18nSet . '/default.php';
        
        // 开发模式不用读取缓存
        if (Q_DEVELOPMENT !== 'develop' && is_file ( $this->objProject->path_cache_i18n . $sCacheFile ) && is_file ( $this->objProject->path_cache_i18n_js . $sCacheFile )) {
            i18n::addI18n ( $sI18nSet, ( array ) (include $this->objProject->path_cache_i18n . $sCacheFile) );
        } else {
            
            /**
             * 分析语言包
             */
            $arrAllI18nDir = [ 
                    Q_PATH . '/~@~/i18n/' . $sI18nSet, // 系统语言包
                    $this->objProject->path_common . '/' . $sI18nSet, // com语言包
                    $this->objProject->path_app_i18n . '/' . $sI18nSet 
            ]; // 应用语言包
               
            // 扩展语言包
            if ($this->objProject->path_app_i18n_extend) {
                if (is_array ( $this->objProject->path_app_i18n_extend )) {
                    $arrAllI18nDir = array_merge ( $arrAllI18nDir, $this->objProject->path_app_i18n_extend );
                } else {
                    $arrAllI18nDir [] = $this->objProject->path_app_i18n_extend;
                }
            }
            $arrFiles = tool::findPoFile ( $arrAllI18nDir );
            
            /**
             * 保存到缓存文件
             */
            i18n::addI18n ( $sI18nSet, tool::saveToPhp ( $arrFiles ['php'], $this->objProject->path_cache_i18n . $sCacheFile ) );
            tool::saveToJs ( $arrFiles ['js'], $this->objProject->path_cache_i18n_js . $sCacheFile, $sI18nSet );
            
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
    private function initApp_($in) {
        $sAppName = $this->objProject->app_name;
        $sAppPath = $this->objProject->path_application . '/' . $sAppName;
        $sRuntime = $this->objProject->path_runtime;
        
        // 各种缓存组件路径
        foreach ( [ 
                'file',
                'log',
                'table',
                'theme',
                'option',
                'i18n' 
        ] as $sPath ) {
            $this->objProject->instance ( 'path_cache_' . $sPath, $sRuntime . '/' . $sPath );
        }
        $this->objProject->instance ( 'path_cache_i18n_js', $this->objProject->path_public . '/js/i18n/' . $sAppName ); // 默认 JS 语言包缓存目录
                                                                                                                        
        // 应用组件
        foreach ( [ 
                'option',
                'theme',
                'i18n' 
        ] as $sPath ) {
            $this->objProject->instance ( 'path_app_' . $sPath, $sAppPath . '/' . $sPath );
        }
        $this->objProject->instance ( 'path_app_theme_extend', '' );
    }
    
    /**
     * 装配注册节点
     *
     * @param string $strController            
     * @param string $strAction            
     * @return string
     */
    private function packControllerAndAction_($strController, $strAction = '') {
        return $this->objProject->app_name . '://' . $strController . ($strAction ? '/' . $strAction : '');
    }
    
    /**
     * 合并 router 参数
     *
     * @param array $arrRouter            
     * @param array $arrNewRouter            
     * @return array
     */
    private function mergeRouter_(array $arrRouter, array $arrNewRouter) {
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
    
    /**
     * 分析自动注入
     *
     * @param mixed $mixClassOrCallback            
     * @param boolean $booClass            
     * @return object|NULL
     */
    private function parseAutoInjection_($mixClassOrCallback, $booClass = true) {
        if (($mixClassOrCallback = $booClass === true ? \Q::getConstructFirstParamClass ( $mixClassOrCallback ) : \Q::getCallbackFirstParamClass ( $mixClassOrCallback )) && \Q::classExists ( $mixClassOrCallback, false, true ) && \Q::isKindOf ( $mixClassOrCallback, 'Q\factory\factory' )) {
            $mixClassOrCallback = new $mixClassOrCallback ( $this->objProject );
            $mixClassOrCallback->register ();
            return $mixClassOrCallback;
        }
        return null;
    }
}
