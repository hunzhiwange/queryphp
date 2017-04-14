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
    private $arrProjectOption = [ ];
    
    /**
     * 项目属性
     *
     * @var array
     */
    private $arrProp = [ 
            
            /**
             * 项目基本
             */
            'project_path' => '',
            'com_path' => '', // 公共组件
            'app_path' => '', // 应用基础路径
            'apppublic_path' => '', // 应用公共资源路径
            'vendor_path' => '', // Composer 公共组件
            'runtime_path' => '', // 缓存路径
            
            /**
             * URL 地址
             */
            'url_enter' => '', // php 文件所在 url 地址如 http://myapp.com/index.php
            'url_root' => '', // 网站 root http://myapp.com
            'url_public' => '' 
    ]; // 网站 public http://myapp.com/public
    
    /**
     * 应用程序实例
     *
     * @var app
     */
    private static $arrApps = [ ];
    
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
     * @param array $arrProjectOption            
     * @return void
     */
    public function __construct($arrProjectOption) {
        // 项目配置
        $this->arrProjectOption = $arrProjectOption;
        
        // 注册框架基础工厂
        $this->registerMvcFactory_ ()->
        
        // 注册核心工厂提供者
        registerCoreFactory_ ();
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
     * @param array $arrProjectOption            
     * @return Q\mvc\project
     */
    static public function singleton($arrProjectOption = []) {
        if (self::$objProject !== null) {
            return self::$objProject;
        } else {
            return self::$objProject = new self ( $arrProjectOption );
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
            return parent::__get ( $sName );
        }
    }
    
    /**
     * 设置支持属性参数
     *
     * @param string $sName
     *            支持的项
     * @param string $sVal
     *            支持的值、
     * @return void
     */
    public function __set($sName, $sVal) {
        if (array_key_exists ( $sName, $this->arrProp )) {
            $this->arrProp [$sName] = $sVal;
        } else {
            return parent::__set ( $sName, $sVal );
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
            $sAppName = $_REQUEST ['app'];
        }
        
        return isset ( self::$arrApps [$sAppName] ) ? self::$arrApps [$sAppName] : null;
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
        $this->register ( 'app', function (project $objProject, $sApp, $arrProjectOption = []) {
            return app::instance ( $objProject, $sApp, $arrProjectOption );
        } );
        
        // 注册请求
        $this->register ( 'request', function () {
            return new request ();
        } );
        
        // 注册启动程序
        $this->register ( 'bootstrap', new bootstrap ( $this, $this->arrProjectOption ) );
        
        // 返回自身
        return $this;
    }
    
    /**
     * 框架核心工厂
     *
     * @return $this
     */
    private function registerCoreFactory_() {
    }
}
