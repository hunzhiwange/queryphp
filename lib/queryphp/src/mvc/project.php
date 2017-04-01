<?php
/*
 * [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
 * ©2010-2017 http://queryphp.com All rights reserved.
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @version $$
 * @date 2017.01.14
 * @since 1.0
 */
namespace Q\mvc;

use Q\router\url;

/**
 * 项目管理
 *
 * @author Xiangmin Liu
 */
class project {
    
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
     * 请求参数
     *
     * @var array
     */
    public static $in = [ ];
    
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
     * 项目是否已经初始化
     *
     * @var boolean
     */
    private static $booInit = false;
    
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
     * @param array $in            
     * @return app
     */
    public function __construct($in = []) {
        // 项目只允许初始化一次
        if (self::$booInit === true) {
            return $this;
        }
        self::$booInit = true;
        
        /**
         * 项目初始化
         */
        
        // 移除自动转义和过滤全局变量
        \Q::stripslashesMagicquotegpc ();
        if (isset ( $_REQUEST ['GLOBALS'] ) or isset ( $_FILES ['GLOBALS'] )) {
            \Q::errorMessage ( 'GLOBALS not allowed!' );
        }
        
        if (! isset ( $in ['project_path'] ) || ! is_dir ( $in ['project_path'] )) {
            \Q::errorMessage ( "project dir is not exists" );
        }
        $this->project_path = $in ['project_path'];
        
        // 初始化
        $this->initProject_ ( $in );
        
        // 注册公共组件命名空间
        \Q::import ( 'com', $this->com_path, [ 
                'ignore' => [ 
                        'i18n',
                        'option',
                        'theme' 
                ] 
        ] );
        
        // 尝试导入 Composer PSR-4
        \Q::importComposer ( $this->vendor_path );
        
        // 载入 project 引导文件
        if (is_file ( ($strBootstrap = $this->com_path . '/bootstrap.php') )) {
            require $strBootstrap;
        }
        
        /**
         * 注册初始化应用
         */
        
        // 注册初始化应用
        self::registerApp ( app::run ( $this, self::INIT_APP, $in ), self::INIT_APP );
        
        // 解析系统URL
        self::$in = $this->checkIn_ ( url::run ()->in () );
        
        // 解析应用 URL 路径
        if (! \Q::isCli ()) {
            $this->initUrl_ ();
        }
        
        /**
         * 执行当前应用
         */
        if (isset ( self::$arrApps [self::$in ['app']] )) {
            return $this;
        }
        
        // 创建 & 注册
        self::registerApp ( ($objApp = app::run ( $this, self::$in ['app'], $in )), self::$in ['app'] );
        
        // 执行
        $objApp->app ();
        
        return $this;
    }
    
    /**
     * APP 入口
     *
     * @param array $in            
     * @return app
     */
    static public function run($in = []) {
        return new self ( $in );
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
        if (! $sAppName) {
            $sAppName = self::$in ['app'];
        }
        
        return isset ( self::$arrApps [$sAppName] ) ? self::$arrApps [$sAppName] : null;
    }
    
    /**
     * 初始化项目
     *
     * @param array $in
     *            参数
     * @return void
     */
    private function initProject_($in) {
        
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
        
        $this->arrProp = array_merge ( $this->arrProp, $arrDefault, $in );
        
        unset ( $in, $arrDefault );
    }
    
    /**
     * 解析 web url 路径地址
     *
     * @return void
     */
    private function initUrl_() {
        // 分析 php 入口文件路径
        $sEnterBak = $sEnter = $this->url_enter;
        if (! $sEnter) {
            // php 文件
            if (\Q::isCgi ()) {
                $arrTemp = explode ( '.php', $_SERVER ["PHP_SELF"] ); // CGI/FASTCGI模式下
                $sEnter = rtrim ( str_replace ( $_SERVER ["HTTP_HOST"], '', $arrTemp [0] . '.php' ), '/' );
            } else {
                $sEnter = rtrim ( $_SERVER ["SCRIPT_NAME"], '/' );
            }
            $sEnterBak = $sEnter;
            
            // 如果为重写模式
            if ($GLOBALS ['~@option'] ['url_rewrite'] === TRUE) {
                $sEnter = dirname ( $sEnter );
                if ($sEnter == '\\') {
                    $sEnter = '/';
                }
            }
        }
        
        // 网站 URL 根目录
        $sRoot = $this->url_root;
        if (! $sRoot) {
            $sRoot = dirname ( $sEnterBak );
            $sRoot = ($sRoot == '/' || $sRoot == '\\') ? '' : $sRoot;
        }
        
        // 网站公共文件目录
        $sPublic = $this->url_public;
        if (! $sPublic) {
            $sPublic = $sRoot . '/public';
        }
        
        $GLOBALS ['~@url'] ['url_enter'] = $this->url_enter = $sEnter;
        $GLOBALS ['~@url'] ['url_root'] = $this->url_root = $sRoot;
        $GLOBALS ['~@url'] ['url_public'] = $this->url_public = $sPublic;
        unset ( $sEnter, $sEnterBak, $sRoot, $sPublic );
    }
    
    /**
     * 检查 URL 非法请求
     *
     * @param
     *            $in
     * @return void
     */
    private function checkIn_($in) {
        return $in;
    }
}
