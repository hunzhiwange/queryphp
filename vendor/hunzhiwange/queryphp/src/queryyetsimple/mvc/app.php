<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace queryyetsimple\mvc;

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

use ReflectionException;
use ReflectionMethod;
use queryyetsimple\http\response;
use queryyetsimple\exception\exceptions;
use queryyetsimple\router\router;
use queryyetsimple\filesystem\directory;
use queryyetsimple\psr4\psr4;
use queryyetsimple\option\option;
use queryyetsimple\option\tool as option_tool;
use queryyetsimple\helper\helper;
use queryyetsimple\i18n\i18n;
use queryyetsimple\i18n\tool as i18n_tool;

/**
 * 应用程序对象
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2016.11.18
 * @version 1.0
 */
class app {
    
    /**
     * 当前项目
     *
     * @var queryyetsimple\mvc\project
     */
    private $objProject = null;
    
    /**
     * 默认
     *
     * @var string
     */
    const INIT_APP = '~_~';
    
    /**
     * 项目配置
     *
     * @var array
     */
    private $arrOption = [ ];
    
    /**
     * app 名字
     *
     * @var array
     */
    private $strApp;
    
    /**
     * 配置命名空间
     *
     * @var array
     */
    private $arrOptionNamespace = [ 
            'app',
            'cache',
            'console',
            'cookie',
            'database',
            'debug',
            'i18n',
            'log',
            'queue',
            'session',
            'url',
            'view',
            'router' 
    ];
    
    /**
     * 执行事件流程
     *
     * @var array
     */
    private $arrEvent = [ 
            'registerException',
            'initialization',
            'loadBootstrap',
            'view',
            'i18n',
            'request',
            'response' 
    ];
    
    /**
     * 构造函数
     *
     * @param queryyetsimple\mvc\project $objProject            
     * @param string $sApp            
     * @param array $arrOption            
     * @return app
     */
    public function __construct(project $objProject, $sApp, $arrOption = []) {
        $this->objProject = $objProject;
        $this->strApp = $sApp;
        $this->arrOption = $arrOption;
    }
    
    /**
     * 执行应用
     *
     * @return void
     */
    public function run() {
        foreach ( $this->arrEvent as $strEvent ) {
            $strEvent = $strEvent . 'Run_';
            $this->{$strEvent} ();
        }
        
        return $this;
    }
    
    /**
     * 初始化应用
     *
     * @param string $sApp            
     * @return \queryyetsimple\mvc\app
     */
    public function bootstrap($sApp = null) {
        if (! is_null ( $sApp ))
            $this->strApp = $sApp;
        $this->setPath_ ();
        $this->loadOption_ ();
        return $this;
    }
    
    /**
     * 注册命名空间
     *
     * @return \queryyetsimple\mvc\app
     */
    public function namespaces() {
        foreach ( option::gets ( '~apps~' ) as $strApp ) {
            psr4::import ( $strApp, $this->objProject->path_application . '/' . $strApp, [ 
                    'ignore' => [ 
                            'interfaces' 
                    ],
                    'force' => Q_DEVELOPMENT === 'development' 
            ] );
        }
        
        foreach ( option::gets ( 'namespace' ) as $strNamespace => $strPath ) {
            psr4::import ( $strNamespace, $strPath, [ 
                    'ignore' => [ ],
                    'force' => Q_DEVELOPMENT === 'development' 
            ] );
        }
        
        return $this;
    }
    
    /**
     * 注册应用提供者
     *
     * @return void
     */
    public function registerAppProvider() {
        $this->objProject->registerAppProvider ( option::gets ( 'provider' ), option::gets ( 'provider_with_cache' ) );
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
                    case is_callable ( $mixModule ) :
                        $this->registerAction ( $sController, $sAction, $mixModule );
                        break;
                    
                    // 如果为方法则注册为方法
                    case is_object ( $mixModule ) && (method_exists ( $mixModule, 'run' ) || helper::isKindOf ( $mixModule, 'queryyetsimple\mvc\action' )) :
                        $this->registerAction ( $sController, $sAction, [ 
                                $mixModule,
                                'run' 
                        ] );
                        break;
                    
                    // 如果为控制器实例，注册为回调
                    case helper::isKindOf ( $mixModule, 'queryyetsimple\mvc\controller' ) :
                    // 实例回调
                    case is_object ( $mixModule ) :
                    // 静态类回调
                    case is_string ( $mixModule ) && is_callable ( [ 
                            $mixModule,
                            $sAction 
                    ] ) :
                        $this->registerAction ( $sController, $sAction, [ 
                                $mixModule,
                                $sAction 
                        ] );
                        break;
                    
                    // 数组支持,方法名即数组的键值,注册方法
                    case is_array ( $mixModule ) :
                        if (isset ( $mixModule [$sAction] )) {
                            $this->registerAction ( $sController, $sAction, $mixModule [$sAction] );
                        } else {
                            exceptions::throwException ( __ ( '数组控制器不存在 %s 方法键值', $sAction ), 'queryyetsimple\mvc\exception' );
                        }
                        break;
                    
                    // 简单数据直接输出
                    case is_scalar ( $mixModule ) :
                        $this->registerAction ( $sController, $sAction, $mixModule );
                        break;
                    
                    default :
                        exceptions::throwException ( __ ( '注册的控制器类型 %s 不受支持', $sController ), 'queryyetsimple\mvc\exception' );
                        break;
                }
            } else {
                // 尝试读取默认控制器
                $sModuleClass = '\\' . $this->strApp . '\\application\\controller\\' . $sController;
                if (class_exists ( $sModuleClass )) {
                    
                    // 自动注入
                    $oModule = $this->objProject->make ( $sModuleClass );
                    $oModule->project ( $this->objProject );
                    
                    // 注册控制器
                    $this->registerController ( $sController, $oModule );
                    
                    // 注册方法
                    $this->registerAction ( $sController, $sAction, [ 
                            $oModule,
                            $sAction 
                    ] );
                } else {
                    // 默认控制器不存在，尝试直接读取方法类
                    $sActionClass = '\\' . $this->objProject->app_name . '\\application\\controller\\' . $sController . '\\' . $sAction;
                    if (class_exists ( $sActionClass )) {
                        // 注册控制器
                        $this->registerController ( $sController, $this->controllerDefault () );
                        
                        // 自动注入
                        $oAction = $this->objProject->make ( $sActionClass );
                        
                        if (helper::isKindOf ( $oAction, 'queryyetsimple\mvc\action' )) {
                            // 注册方法
                            $this->registerAction ( $sController, $sAction, [ 
                                    $oAction,
                                    'run' 
                            ] );
                        } else {
                            exceptions::throwException ( __ ( '方法 %s 必须为  queryyetsimple\mvc\action 实例', $sAction ), 'queryyetsimple\mvc\exception' );
                        }
                    }
                }
            }
        }
        
        // 执行方法
        return $this->action ( $sController, $sAction );
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
                // 判断是否为控制器回调
                case is_array ( $mixAction ) && isset ( $mixAction [1] ) && helper::isKindOf ( $mixAction [0], 'queryyetsimple\mvc\controller' ) :
                    try {
                        $objClass = new ReflectionMethod ( $mixAction [0], $mixAction [1] );
                        if ($objClass->isPublic () && ! $objClass->isStatic ()) {
                            return $this->objProject->call ( $mixAction );
                        } else {
                            exceptions::throwException ( __ ( '控制器 %s 的方法 %s 不存在', $sController, $sAction ), 'queryyetsimple\mvc\exception' );
                        }
                    } catch ( ReflectionException $oE ) {
                        // 请求默认子方法器
                        return call_user_func_array ( [ 
                                $mixAction [0],
                                'action' 
                        ], [ 
                                $mixAction [1] 
                        ] );
                    }
                    break;
                
                // 判断是否为回调
                case is_callable ( $mixAction ) :
                    return $this->objProject->call ( $mixAction );
                    break;
                
                // 如果为方法则注册为方法
                case helper::isKindOf ( $mixAction, 'queryyetsimple\mvc\action' ) :
                case is_object ( $mixAction ) :
                    if (method_exists ( $mixAction, 'run' )) {
                        // 注册方法
                        $this->registerAction ( $sController, $sAction, [ 
                                $mixAction,
                                'run' 
                        ] );
                        return $this->action ( $sController, $sAction );
                    } else {
                        exceptions::throwException ( __ ( '方法对象不存在执行入口  run' ), 'queryyetsimple\mvc\exception' );
                    }
                    break;
                
                // 数组支持,方法名即数组的键值,注册方法
                case is_array ( $mixAction ) :
                    return $mixAction;
                    break;
                
                // 简单数据直接输出
                case is_scalar ( $mixAction ) :
                    return $mixAction;
                    break;
                
                default :
                    exceptions::throwException ( __ ( '注册的方法类型 %s 不受支持', $sAction ), 'queryyetsimple\mvc\exception' );
                    break;
            }
        } else {
            exceptions::throwException ( __ ( '控制器 %s 的方法 %s 未注册', $sController, $sAction ), 'queryyetsimple\mvc\exception' );
        }
    }
    
    /**
     * 获取控制器
     *
     * @param string $sControllerName            
     * @return 注册的控制器
     */
    public function getController($sControllerName) {
        $mixController = router::getBinds ( $this->packControllerAndAction_ ( $sControllerName ) );
        if ($mixController !== null) {
            return $mixController;
        }
        return router::getBinds ( $sControllerName );
    }
    
    /**
     * 是否存在控制器
     *
     * @param string $sControllerName            
     * @return boolean
     */
    public function hasController($sControllerName) {
        $booHasController = router::hasBinds ( $this->packControllerAndAction_ ( $sControllerName ) );
        if ($booHasController === false) {
            $booHasController = router::hasBinds ( $sControllerName );
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
    public function registerController($sControllerName, $mixController) {
        router::binds ( $this->packControllerAndAction_ ( $sControllerName ), $mixController );
    }
    
    /**
     * 获取方法
     *
     * @param string $sActionName            
     * @return 注册的方法
     */
    public function getAction($sControllerName, $sActionName) {
        $mixAction = router::getBinds ( $this->packControllerAndAction_ ( $sControllerName, $sActionName ) );
        if ($mixAction !== null) {
            return $mixAction;
        }
        return router::getBinds ( $sControllerName . '/' . $sActionName );
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
    public function hasAction($sControllerName, $sActionName) {
        $booHasAction = router::hasBinds ( $this->packControllerAndAction_ ( $sControllerName, $sActionName ) );
        if ($booHasAction === false) {
            $booHasAction = router::hasBinds ( $sControllerName . '/' . $sActionName );
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
    public function registerAction($sControllerName, $sActionName, $mixAction) {
        return router::binds ( $this->packControllerAndAction_ ( $sControllerName, $sActionName ), $mixAction );
    }
    
    /**
     * 获取注册默认控制器
     *
     * @return boolean
     */
    public function controllerDefault() {
        if (! $this->hasController ( 'query_default' )) {
            $this->registerController ( 'query_default', $this->objProject->make ( 'controller' ) );
        }
        return $this->getController ( 'query_default' );
    }
    
    /**
     * 接管 PHP 异常处理
     *
     * @return void
     */
    private function registerExceptionRun_() {
        if (PHP_SAPI != 'cli') {
            set_exception_handler ( is_callable ( option::gets ( 'debug\exception_handle' ) ) ? option::gets ( 'debug\exception_handle' ) : [ 
                    'queryyetsimple\exception\handle',
                    'exceptionHandle' 
            ] );
        }
    }
    
    /**
     * 初始化处理
     *
     * @return void
     */
    private function initializationRun_() {
        if (function_exists ( 'date_default_timezone_set' )) {
            date_default_timezone_set ( option::gets ( 'time_zone' ) );
        }
        if (function_exists ( 'gz_handler' ) && option::gets ( 'start_gzip' )) {
            ob_start ( 'gz_handler' );
        } else {
            ob_start ();
        }
    }
    
    /**
     * 载入 app 引导文件
     *
     * @return void
     */
    private function loadBootstrapRun_() {
        if (is_file ( ($strBootstrap = (defined ( 'PATH_APP_BOOTSTRAP' ) ? PATH_APP_BOOTSTRAP : $this->objProject->path_application . '/' . $this->strApp . '/bootstrap.php')) )) {
            require $strBootstrap;
        }
    }
    
    /**
     * 初始化视图
     *
     * @return void
     */
    private function viewRun_() {
        // 设置应用主题名字
        $this->objProject->instance ( 'name_app_theme', $sThemeSet = view::parseContexts () );
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
    private function i18nRun_() {
        if (! option::gets ( 'i18n\on' ))
            return;
        
        $sI18nSet = i18n::parseContexts ();
        if (option::gets ( 'i18n\develop' ) == $sI18nSet)
            return;
        
        $sCachePath = $this->getI18nCachePath_ ( $sI18nSet );
        $sCacheJsPath = $this->getI18nCacheJsPath_ ( $sI18nSet );
        
        if (Q_DEVELOPMENT !== 'development' && is_file ( $sCachePath ) && is_file ( $sCacheJsPath )) {
            i18n::addI18ns ( $sI18nSet, ( array ) (include $sCachePath) );
        } else {
            $arrFiles = i18n_tool::findPoFile ( $this->getI18nDir_ ( $sI18nSet ) );
            i18n::addI18ns ( $sI18nSet, i18n_tool::saveToPhp ( $arrFiles ['php'], $sCachePath ) );
            i18n_tool::saveToJs ( $arrFiles ['js'], $sCacheJsPath, $sI18nSet );
            unset ( $sI18nSet, $arrFiles, $sCachePath, $sCacheJsPath );
        }
    }
    
    /**
     * 请求结果初始化
     *
     * @return void
     */
    private function requestRun_() {
        $this->objProject->instance ( 'app_name', $this->strApp );
        $this->objProject->instance ( 'controller_name', $this->objProject->request->controller () );
        $this->objProject->instance ( 'action_name', $this->objProject->request->action () );
    }
    
    /**
     * 执行请求返回相应结果
     *
     * @return void
     */
    private function responseRun_() {
        $mixResponse = $this->controller ();
        if (! ($mixResponse instanceof response)) {
            $mixResponse = response::makes ( $mixResponse );
        }
        $mixResponse->output ();
    }
    
    /**
     * 装配注册节点
     *
     * @param string $strController            
     * @param string $strAction            
     * @return string
     */
    private function packControllerAndAction_($strController, $strAction = '') {
        return $this->strApp . '://' . $strController . ($strAction ? '/' . $strAction : '');
    }
    
    /**
     * 分析配置文件
     *
     * @return void
     */
    private function loadOption_() {
        $this->setOptionRouterCachePath_ ();
        $sCachePath = $this->getOptionCachePath_ ();
        
        // 开发模式不用读取缓存
        if (Q_DEVELOPMENT !== 'development' && is_file ( $sCachePath )) {
            option::resets ( ( array ) (include $sCachePath) );
            
            if ($this->strApp == static::INIT_APP) {
                if (! router::checkExpireds ())
                    return;
                
                if (($arrRouter = option::gets ( 'router\\' ))) {
                    router::importCaches ( $arrRouter );
                }
                
                if (($arrRouterType = option::gets ( '~routers~' ))) {
                    foreach ( $this->getOptionDir_ () as $sDir ) {
                        foreach ( $arrRouterType as $sType ) {
                            if (! is_file ( $strFile = $sDir . '/' . $sType . '.php' ))
                                continue;
                            include $strFile;
                        }
                    }
                }
            }
        } else {
            option_tool::saveToCache ( $this->getOptionDir_ (), $this->getOptionNamespace_ (), $sCachePath, [ 
                    'app' => [ 
                            '~apps~' => directory::lists ( $this->objProject->path_application ) 
                    ] 
            ], $this->strApp == static::INIT_APP );
        }
    }
    
    /**
     * 设置应用路径
     *
     * @return void
     */
    private function setPath_() {
        $sAppName = $this->strApp;
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
            $sPathName = 'path_cache_' . $sPath;
            $this->objProject->instance ( $sPathName, isset ( $this->arrOption [$sPathName] ) ? $this->arrOption [$sPathName] : $sRuntime . '/' . $sPath );
        }
        $this->objProject->instance ( 'path_cache_i18n_js', isset ( $this->arrOption ['path_cache_i18n_js'] ) ? $this->arrOption ['path_cache_i18n_js'] : $this->objProject->path_public . '/js/i18n/' . $sAppName ); // 默认 JS 语言包缓存目录
                                                                                                                                                                                                                      
        // 应用组件
        foreach ( [ 
                'option',
                'theme',
                'i18n' 
        ] as $sPath ) {
            $sPathName = 'path_app_' . $sPath;
            $this->objProject->instance ( $sPathName, isset ( $this->arrOption [$sPathName] ) ? $this->arrOption [$sPathName] : $sAppPath . '/interfaces/' . $sPath );
        }
        $this->objProject->instance ( 'path_app_theme_extend', isset ( $this->arrOption ['path_app_theme_extend'] ) ? $this->arrOption ['path_app_theme_extend'] : '' );
    }
    
    /**
     * 返回配置命名空间
     *
     * @return array
     */
    private function getOptionNamespace_() {
        return $this->arrOptionNamespace;
    }
    
    /**
     * 返回 i18n 目录
     *
     * @param string $sI18nSet            
     * @return array
     */
    private function getI18nDir_($sI18nSet) {
        $arrI18nDir = [ 
                Q_PATH . '/resource/i18n/' . $sI18nSet,
                $this->objProject->path_common . '/interfaces/i18n/' . $sI18nSet,
                $this->objProject->path_app_i18n . '/' . $sI18nSet 
        ];
        
        if ($this->objProject->path_app_i18n_extend) {
            if (is_array ( $this->objProject->path_app_i18n_extend )) {
                $arrI18nDir = array_merge ( $arrI18nDir, array_map ( function ($strDir) use($sI18nSet) {
                    return $strDir . '/' . $sI18nSet;
                }, $this->objProject->path_app_i18n_extend ) );
            } else {
                $arrI18nDir [] = $this->objProject->path_app_i18n_extend . '/' . $sI18nSet;
            }
        }
        
        return $arrI18nDir;
    }
    
    /**
     * 返回 i18n.php 缓存路径
     *
     * @param string $sI18nSet            
     * @return array
     */
    private function getI18nCachePath_($sI18nSet) {
        return $this->objProject->path_cache_i18n . '/' . $sI18nSet . '/default.php';
    }
    
    /**
     * 返回 i18n.js 缓存路径
     *
     * @param string $sI18nSet            
     * @return array
     */
    private function getI18nCacheJsPath_($sI18nSet) {
        return $this->objProject->path_cache_i18n_js . '/' . $sI18nSet . '/default.js';
    }
    
    /**
     * 返回配置目录
     *
     * @return array
     */
    private function getOptionDir_() {
        $arrOptionDir = [ 
                Q_PATH . '/resource/option' 
        ];
        if (is_dir ( $this->objProject->path_common . '/interfaces/option' ))
            $arrOptionDir [] = $this->objProject->path_common . '/interfaces/option';
        $arrOptionDir [] = $this->objProject->path_app_option;
        return $arrOptionDir;
    }
    
    /**
     * 返回配置缓存路径
     *
     * @return array
     */
    private function getOptionCachePath_() {
        return $this->objProject->path_cache_option . '/' . $this->strApp . '.php';
    }
    
    /**
     * 设置路由缓存路径
     *
     * @return array
     */
    private function setOptionRouterCachePath_() {
        router::cachePaths ( $this->objProject->path_cache_option . '/' . $this->strApp . '.router.php' )->development ( Q_DEVELOPMENT === 'development' )->debug ( Q_DEBUG );
    }
    
    /**
     * 拦截匿名注册控制器方法
     *
     * @param 方法名 $sMethod            
     * @param 参数 $arrArgs            
     * @return boolean
     */
    public function __call($sMethod, $arrArgs) {
        $objDefaultController = $this->controllerDefault ();
        return call_user_func_array ( [ 
                $objDefaultController,
                $sMethod 
        ], $arrArgs );
    }
}
