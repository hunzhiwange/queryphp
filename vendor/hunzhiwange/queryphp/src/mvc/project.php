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
use Q\mvc\view;

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
        
        // 注册基础工厂提供者
        registerBaseFactory_ ()->
        
        // 注册框架核心工厂
        registerMvcFactory_ ()->
        
        // 初始化项目路径
        setPath_ ();
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
    static public function bootstrap($arrOption = []) {
        if (self::$objProject !== null) {
            return self::$objProject;
        } else {
            return self::$objProject = new self ( $arrOption );
        }
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
     * 框架基础工厂
     *
     * @return $this
     */
    private function registerBaseFactory_() {
        $arrBaseFactory = [ 
                'Q\mvc\base_factory' 
        ];
        foreach ( $arrBaseFactory as $strFactory ) {
            call_user_func_array ( [ 
                    new $strFactory ( $this ),
                    'register' 
            ], [ ] );
        }
        return $this;
    }
    
    /**
     * 框架 MVC 基础工厂
     *
     * @return $this
     */
    private function registerMvcFactory_() {
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
                'file' => 'Q\cache\file',
                'memcache' => 'Q\cache\memcache',
                
                // cookie
                'cookie' => 'Q\cookie\cookie',
                
                // database
                'database' => 'Q\database\database',
                'select' => 'Q\database\select',
                'mysql' => 'Q\database\mysql',
                
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
                
                // request
                'request' => 'Q\request\request',
                'response' => 'Q\request\response',
                
                // router
                'router' => 'Q\router\router',
                
                // structure
                'collection' => 'Q\structure\collection',
                'queue' => 'Q\structure\queue',
                'stack' => 'Q\structure\stack',
                
                // view
                'view_compilers' => 'Q\view\compilers',
                'view_parsers' => 'Q\view\parsers',
                'view_theme' => 'Q\view\theme',
                
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
            $sUrl = 'url_' . $sUrl;
            $this->instance ( $sUrl, isset ( $this->arrOption [$sUrl] ) ? $this->arrOption [$sUrl] : '' );
        }
    }
}
