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
 * @date 2017.01.14
 * @since 1.0
 */
namespace Q\mvc;

use Q\factory\container;

/**
 * 项目管理
 *
 * @author Xiangmin Liu
 */
class project extends container {
    
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
     * 应用程序实例
     *
     * @var app
     */
    private static $arrApps = [ ];
    
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
        
        // 注册框架基础工厂
        registerMvcFactory_ ()->
        
        // 注册核心工厂提供者
        registerCoreFactory_ ()->
        
        // 初始化项目路径
        setPath_ ();
    }
    
    /**
     * 执行项目
     *
     * @return void
     */
    public function run() {
        $this->make ( 'bootstrap' )->run ( $this->make ( 'request' ) );
    }
    
    /**
     * 返回项目
     *
     * @param array $arrOption            
     * @return Q\mvc\project
     */
    static public function singleton($arrOption = []) {
        if (self::$objProject !== null) {
            return self::$objProject;
        } else {
            return self::$objProject = new self ( $arrOption );
        }
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
     * 是否注册程序实例
     *
     * @param string $sAppName
     *            应用名字
     * @return void
     */
    static function hasApp($sAppName) {
        return isset ( self::$arrApps [$sAppName] );
    }
    
    /**
     * 取得应用程序实例
     *
     * @return App
     */
    static public function getApp($sAppName = '') {
        if (! $sAppName) {
            $sAppName = \Q::project()->request->app();
        }
        return isset ( self::$arrApps [$sAppName] ) ? self::$arrApps [$sAppName] : null;
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
        return isset ( $this->arrOption ['path_application'] ) ? $this->arrOption ['path.applicationp'] : $this->strPath . DIRECTORY_SEPARATOR . 'application';
    }
    
    /**
     * 公共路径
     *
     * @return string
     */
    public function pathCommon() {
        return isset ( $this->arrOption ['path_common'] ) ? $this->arrOption ['path.common'] : $this->strPath . DIRECTORY_SEPARATOR . 'common';
    }
    
    /**
     * 运行路径
     *
     * @return string
     */
    public function pathRuntime() {
        return isset ( $this->arrOption ['path_runtime'] ) ? $this->arrOption ['path.runtime'] : $this->strPath . DIRECTORY_SEPARATOR . '~@~';
    }
    
    /**
     * 资源路径
     *
     * @return string
     */
    public function pathPublic() {
        return isset ( $this->arrOption ['path_public'] ) ? $this->arrOption ['path.public'] : $this->strPath . DIRECTORY_SEPARATOR . 'public';
    }
    
    /**
     * 扩展路径（composer 路径）
     *
     * @return string
     */
    public function pathVendor() {
        return isset ( $this->arrOption ['path_vendor'] ) ? $this->arrOption ['path.vendor'] : $this->strPath . DIRECTORY_SEPARATOR . 'vendor';
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
     * 框架 MVC 基础工厂
     *
     * @return $this
     */
    private function registerMvcFactory_() {
        // 注册 project
        $this->register ( 'project', $this );
        
        // 注册 app
        $this->register ( 'app', function (project $objProject, $sApp, $arrOption = []) {
            return app::instance ( $objProject, $sApp, $arrOption );
        } );
        
        // 注册请求
        $this->register ( 'request', function () {
            return new request ();
        } );
        
        // 注册启动程序
        $this->register ( 'bootstrap', new bootstrap ( $this, $this->arrOption ) );
        
        return $this;
    }
    
    /**
     * 框架核心工厂
     *
     * @return $this
     */
    private function registerCoreFactory_() {
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
            \Q::errorMessage ( "project dir is not set" );
        }
        $this->strPath = rtrim ( $this->arrOption ['path'], '\\' );
        
        // 注册路径
        $this->registerPath_ ();
        
        // 注册 url
        $this->registerUrl_ ();
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
            $this->instance ( 'url_' . $sUrl, isset ( $this->arrOption ['url_'.$sUrl] ) ? $this->arrOption ['url_'.$sUrl] : '' );
        }
    }
}
