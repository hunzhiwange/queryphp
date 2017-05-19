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

use queryyetsimple\support\container;
use queryyetsimple\mvc\view;
use queryyetsimple\exception\exceptions;
use queryyetsimple\helper\helper;
use queryyetsimple\psr4\psr4;

/**
 * 项目管理
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.01.14
 * @version 1.0
 */
class project extends container {
    
    /**
     * 当前项目实例
     *
     * @var queryyetsimple\mvc\project
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
     * 基础服务提供者
     *
     * @var array
     */
    private static $arrBaseProvider = [ 
            'http',
            'log',
            'provider',
            'cookie',
            'i18n',
            'database',
            'event',
            'router' 
    ];
    
    /**
     * 构造函数
     *
     * @param string $strPath            
     * @param array $arrOption            
     * @return void
     */
    public function __construct($strPath, $arrOption = []) {
        // 项目基础配置
        $this->setOption_ ( $arrOption )->
        
        // 初始化项目路径
        setPath_ ( $strPath )->
        
        // 注册别名
        registerAlias_ ()->
        
        // 注册基础提供者 register
        registerBaseProvider_ ()->
        
        // 注册框架核心提供者
        registerMvcProvider_ ()->
        
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
     * @param string $strPath            
     * @param array $arrOption            
     * @return queryyetsimple\mvc\project
     */
    public static function bootstrap($strPath = null, $arrOption = []) {
        if (static::$objProject !== null) {
            return static::$objProject;
        } else {
            return static::$objProject = new self ( $strPath, $arrOption );
        }
    }
    
    /**
     * 注册应用提供者
     *
     * @param array $arrProvider            
     * @param array $arrProviderCache            
     * @return $this
     */
    public function registerAppProvider($arrProvider, $arrProviderCache) {
        return $this->runProvider_ ( $arrProvider, 'register' )->runProvider_ ( $arrProvider, 'bootstrap' )->runBaseProvider_ ( 'register', 'app', $arrProviderCache )->runBaseProvider_ ( 'bootstrap', 'app', $arrProviderCache );
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
        return $this->runBaseProvider_ ( 'register' );
    }
    
    /**
     * 框架基础提供者 bootstrap
     *
     * @return $this
     */
    private function registerBaseProviderBootstrap_() {
        return $this->runBaseProvider_ ( 'bootstrap' );
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
        $this->singleton ( 'queryyetsimple\mvc\app', function (project $objProject, $sApp, $arrOption = []) {
            return new app ( $objProject, $sApp, $arrOption );
        } );
        
        // 注册 controller
        $this->singleton ( 'queryyetsimple\mvc\controller', function (project $objProject) {
            return (new controller ())->project ( $objProject );
        } );
        
        // 注册 view
        $this->singleton ( 'queryyetsimple\mvc\view', function (project $objProject) {
            return view::getNewInstance ( $objProject );
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
                'view' => 'queryyetsimple\mvc\view',
                'controller' => 'queryyetsimple\mvc\controller' 
        ] );
        return $this;
    }
    
    /**
     * 初始化项目路径
     *
     * @param string $strPath            
     * @return $this
     */
    private function setPath_($strPath) {
        // 基础路径
        $this->strPath = rtrim ( $strPath, '\\' );
        
        // 注册路径
        $this->registerPath_ ();
        
        // 注册 url
        $this->registerUrl_ ();
        
        // 设置命名空间缓存包
        psr4::cachePackagePath ( $this->path_runtime . '/namespace' );
        
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
            $objProvider = $this->make ( $strProvider, $this );
            if (method_exists ( $objProvider, $strType )) {
                $this->call ( [ 
                        $objProvider,
                        $strType 
                ] );
            }
        }
        return $this;
    }
    
    /**
     * 运行基础服务提供者
     *
     * @param string $strAction            
     * @param string $strType            
     * @return $this
     */
    private function runBaseProvider_($strAction, $strType = null, $arrProvider = null) {
        helper::registerProvider ( $this, $this->path_runtime . '/provider/' . ($strType ?  : 'base') . '.' . $strAction . '.php', array_map ( function ($strPackage) use($strAction) {
            return sprintf ( 'queryyetsimple\%s\provider\%s', $strPackage, $strAction );
        }, $arrProvider ?  : static::$arrBaseProvider ), Q_DEVELOPMENT === 'development' );
        return $this;
    }
}
