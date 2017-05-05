<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace Q\mvc;

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

use Q\support\container;
use Q\mvc\view;
use Q\traits\dependency\injection as dependency_injection;
use Q\exception\exceptions;

/**
 * 项目管理
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.01.14
 * @version 1.0
 */
class project extends container {
    
    use dependency_injection;
    
    /**
     * 当前项目实例
     *
     * @var Q\mvc\project
     */
    private static $objProject = null;
    
    /**
     * 项目配置
     *
     * @var array
     */
    private $arrOption = [ ];
    
    /**
     * 项目基础路径
     *
     * @var string
     */
    private $strPath;
    
    /**
     * 默认
     *
     * @var string
     */
    const INIT_APP = '~_~';
    
    /**
     * 应用参数名
     *
     * @var string
     */
    const ARGS_APP = 'app';
    
    /**
     * 控制器参数名
     *
     * @var string
     */
    const ARGS_CONTROLLER = 'c';
    
    /**
     * 方法参数名
     *
     * @var string
     */
    const ARGS_ACTION = 'a';
    
    /**
     * 主题参数名
     *
     * @var string
     */
    const ARGS_THEME = '~@theme';
    
    /**
     * 国际化参数名
     *
     * @var string
     */
    const ARGS_I18N = '~@i18n';
    
    /**
     * 构造函数
     *
     * @param array $arrOption            
     * @return void
     */
    public function __construct($arrOption) {
        // 项目基础配置
        $this->setOption_ ( $arrOption )->
        
        // 注册别名
        registerAlias_ ()->
        
        // 注册基础提供者 register
        registerBaseProvider_ ()->
        
        // 注册框架核心提供者
        registerMvcProvider_ ()->
        
        // 初始化项目路径
        setPath_ ()->
        
        // 注册基础提供者 bootstrap
        registerBaseProviderBootstrap_ ();
    }
    
    /**
     * 执行项目
     *
     * @return void
     */
    public function run() {
        $this->make ( bootstrap::class )->run ();
    }
    
    /**
     * 返回项目
     *
     * @param array $arrOption            
     * @return Q\mvc\project
     */
    public static function bootstrap($arrOption = []) {
        if (static::$objProject !== null) {
            return static::$objProject;
        } else {
            return static::$objProject = new self ( $arrOption );
        }
    }
    
    /**
     * 注册应用提供者
     *
     * @param array $arrProvider            
     * @return $this
     */
    public function registerAppProvider($arrProvider) {
        return $this->runProvider_ ( $arrProvider, 'register' )->runProvider_ ( $arrProvider, 'bootstrap' );
    }
    
    /**
     * 基础路径
     *
     * @return string
     */
    public function path() {
        return $this->strPath;
    }
    
    /**
     * 应用路径
     *
     * @return string
     */
    public function pathApplication() {
        return isset ( $this->arrOption ['path_application'] ) ? $this->arrOption ['path_applicationp'] : $this->strPath . DIRECTORY_SEPARATOR . 'application';
    }
    
    /**
     * 公共路径
     *
     * @return string
     */
    public function pathCommon() {
        return isset ( $this->arrOption ['path_common'] ) ? $this->arrOption ['path_common'] : $this->strPath . DIRECTORY_SEPARATOR . 'common';
    }
    
    /**
     * 运行路径
     *
     * @return string
     */
    public function pathRuntime() {
        return isset ( $this->arrOption ['path_runtime'] ) ? $this->arrOption ['path_runtime'] : $this->strPath . DIRECTORY_SEPARATOR . '~@~';
    }
    
    /**
     * 资源路径
     *
     * @return string
     */
    public function pathPublic() {
        return isset ( $this->arrOption ['path_public'] ) ? $this->arrOption ['path_public'] : $this->strPath . DIRECTORY_SEPARATOR . 'public';
    }
    
    /**
     * 扩展路径（composer 路径）
     *
     * @return string
     */
    public function pathVendor() {
        return isset ( $this->arrOption ['path_vendor'] ) ? $this->arrOption ['path_vendor'] : $this->strPath . DIRECTORY_SEPARATOR . 'vendor';
    }
    
    /**
     * public url
     *
     * @return string
     */
    public function urlPublic() {
        return $this->url_public;
    }
    
    /**
     * root url
     *
     * @return string
     */
    public function urlRoot() {
        return $this->url_root;
    }
    
    /**
     * enter url
     *
     * @return string
     */
    public function urlEnter() {
        return $this->url_enter;
    }
    
    /**
     * 设置项目基础配置
     *
     * @param array $arrOption            
     * @return $this
     */
    private function setOption_($arrOption) {
        $this->arrOption = $arrOption;
        return $this;
    }
    
    /**
     * 框架基础提供者 register
     *
     * @return $this
     */
    private function registerBaseProvider_() {
        return $this->runProvider_ ( [ 
                'Q\support\base_provider' 
        ], 'register' );
    }
    
    /**
     * 框架基础提供者 bootstrap
     *
     * @return $this
     */
    private function registerBaseProviderBootstrap_() {
        return $this->runProvider_ ( [ 
                'Q\support\base_provider' 
        ], 'bootstrap' );
    }
    
    /**
     * 框架 MVC 基础提供者
     *
     * @return $this
     */
    private function registerMvcProvider_() {
        // 注册启动程序
        $this->register ( new bootstrap ( $this, $this->arrOption ) );
        
        // 注册 app
        $this->register ( app::class, function (project $objProject, $sApp, $arrOption = []) {
            return app::instance ( $objProject, $sApp, $arrOption );
        } );
        
        // 注册 controller
        $this->register ( 'Q\mvc\controller', function () {
            return \Q::newInstanceArgs ( 'Q\mvc\controller', func_get_args () );
        } );
        
        // 注册 action
        $this->register ( 'Q\mvc\action', function () {
            return \Q::newInstanceArgs ( 'Q\mvc\action', func_get_args () );
        } );
        
        // 注册 view
        $this->singleton ( 'Q\mvc\view', function () {
            return view::run ();
        } );
        
        return $this;
    }
    
    /**
     * 注册别名
     *
     * @return void
     */
    private function registerAlias_() {
        $this->alias ( [
                // cache
                'filecache' => 'Q\cache\filecache',
                'memcache' => 'Q\cache\memcache',
                
                // collection
                'collection' => 'Q\datastruct\collection\collection',
                
                // cookie
                'cookie' => 'Q\cookie\cookie',
                
                // database
                'database' => 'Q\database\database',
                
                // event
                'event' => 'Q\event\event',
                
                // exception
                'exception' => 'Q\exception\exception',
                
                // i18n
                'i18n' => 'Q\i18n\i18n',
                'i18n_tool' => 'Q\i18n\tool',
                
                // image
                'image' => 'Q\image\image',
                
                // log
                'log' => 'Q\log\log',
                
                // mvc
                'controller' => 'Q\mvc\controller',
                'action' => 'Q\mvc\action',
                'view' => 'Q\mvc\view',
                
                // option
                'option' => 'Q\option\option',
                
                // queue
                'queue' => 'Q\datastruct\queue\queue',
                'stack' => 'Q\datastruct\queue\stack',
                
                // request
                'request' => 'Q\request\request',
                'response' => 'Q\request\response',
                
                // router
                'router' => 'Q\router\router',
                
                // xml
                'xml' => 'Q\xml\xml' 
        ] );
        return $this;
    }
    
    /**
     * 初始化项目路径
     *
     * @return $this
     */
    private function setPath_() {
        // 基础路径
        if (! isset ( $this->arrOption ['path'] )) {
            exceptions::throws ( "project dir is not set" );
        }
        $this->strPath = rtrim ( $this->arrOption ['path'], '\\' );
        
        // 注册路径
        $this->registerPath_ ();
        
        // 注册 url
        $this->registerUrl_ ();
        
        return $this;
    }
    
    /**
     * 注册路径到容器
     *
     * @return void
     */
    private function registerPath_() {
        // 基础路径
        $this->instance ( 'path', $this->path () );
        
        // 其它路径
        foreach ( [ 
                'application',
                'common',
                'runtime',
                'public',
                'vendor' 
        ] as $sKey => $sPath ) {
            $this->instance ( 'path_' . $sPath, $this->{'path' . ucwords ( $sPath )} () );
        }
    }
    
    /**
     * 注册 url 到容器
     *
     * @return void
     */
    private function registerUrl_() {
        foreach ( [ 
                'enter',
                'root',
                'public' 
        ] as $sKey => $sUrl ) {
            $sUrl = 'url_' . $sUrl;
            $this->instance ( $sUrl, isset ( $this->arrOption [$sUrl] ) ? $this->arrOption [$sUrl] : '' );
        }
    }
    
    /**
     * 运行服务提供者
     *
     * @param array $arrProvider            
     * @param string $strType            
     * @return void
     */
    private function runProvider_($arrProvider, $strType) {
        foreach ( $arrProvider as $strProvider ) {
            $objProvider = $this->getObjectByClassAndArgs_ ( $strProvider, [ 
                    $this 
            ] );
            if (method_exists ( $objProvider, $strType )) {
                $this->getObjectCallbackResultWithMethodArgs_ ( [ 
                        $objProvider,
                        $strType 
                ], [ ] );
            }
        }
        return $this;
    }
}
