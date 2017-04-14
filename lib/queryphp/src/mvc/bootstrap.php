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
 * @date 2017.04.13
 * @since 4.0
 */
namespace Q\mvc;

/**
 * 启动程序
 *
 * @author Xiangmin Liu
 */
class bootstrap {
    
    /**
     * 父控制器
     *
     * @var Q\mvc\project
     */
    private $objProject = null;
    
    /**
     * 项目配置
     *
     * @var array
     */
    private $arrProjectOption = [ ];
    
    /**
     * 请求
     *
     * @var Q\mvc\request
     */
    private $objRequest = null;
    
    /**
     * 执行事件流程
     *
     * @var array
     */
    private $arrEvent = [ 
            'check',
            'projectPath',
            'initProject',
            'request',
            'parseProjectUrl',
            'runApp' 
    ];
    
    /**
     * 构造函数
     *
     * @param Q\mvc\project $objProject            
     * @param array $arrProjectOption            
     * @return void
     */
    public function __construct(project $objProject = null, $arrProjectOption = []) {
        $this->objProject = $objProject;
        $this->arrProjectOption = $arrProjectOption;
    }
    
    /**
     * 执行初始化事件
     *
     * @param $objRequest Q\mvc\request            
     * @return void
     */
    public function run(request $objRequest) {
        $this->objRequest = $objRequest;
        foreach ( $this->arrEvent as $strEvent ) {
            $strEvent = $strEvent . '_';
            $this->{$strEvent} ();
        }
    }
    
    /**
     * 项目初始化验证
     *
     * @return void
     */
    private function check_() {
        // 移除自动转义和过滤全局变量
        \Q::stripslashesMagicquotegpc ();
        if (isset ( $_REQUEST ['GLOBALS'] ) or isset ( $_FILES ['GLOBALS'] )) {
            \Q::errorMessage ( 'GLOBALS not allowed!' );
        }
        
        if (! isset ( $this->arrProjectOption ['project_path'] ) || ! is_dir ( $this->arrProjectOption ['project_path'] )) {
            \Q::errorMessage ( "project dir is not exists" );
        }
    }
    
    /**
     * 项目路径解析
     *
     * @return void
     */
    private function projectPath_() {
        $this->objProject->project_path = $this->arrProjectOption ['project_path'];
        foreach ( [ 
                'app_path' => 'app', // app
                'com_path' => 'com', // com
                'runtime_path' => '~@~', // runtime
                'apppublic_path' => 'www/public', // public
                'vendor_path' => 'lib/vendor' 
        ] as $sKey => $sPath ) {
            ! isset ( $this->arrProjectOption [$sKey] ) && $this->objProject->{$sKey} = $this->objProject->project_path . '/' . $sPath;
        }
    }
    
    /**
     * 初始化项目
     *
     * @return void
     */
    private function initProject_() {
        // 注册公共组件命名空间
        \Q::import ( 'com', $this->objProject->com_path, [ 
                'ignore' => [ 
                        'i18n',
                        'option',
                        'theme' 
                ] 
        ] );
        
        // 尝试导入 Composer PSR-4
        \Q::importComposer ( $this->objProject->vendor_path );
        
        // 载入 project 引导文件
        if (is_file ( ($strBootstrap = $this->objProject->com_path . '/bootstrap.php') )) {
            require $strBootstrap;
        }
    }
    
    /**
     * 执行请求
     *
     * @return void
     */
    private function request_() {
        // 注册初始化应用
        project::registerApp ( $this->objProject->make ( 'app', project::INIT_APP, $this->arrProjectOption )->run (), project::INIT_APP );
        
        // 完成请求
        $this->objRequest->run ();
    }
    
    /**
     * 解析项目 url 路径地址
     *
     * @return void
     */
    private function parseProjectUrl_() {
        if (\Q::isCli ()) {
            return;
        }
        
        // 分析 php 入口文件路径
        $sEnterBak = $sEnter = $this->objProject->url_enter;
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
        $sRoot = $this->objProject->url_root;
        if (! $sRoot) {
            $sRoot = dirname ( $sEnterBak );
            $sRoot = ($sRoot == '/' || $sRoot == '\\') ? '' : $sRoot;
        }
        
        // 网站公共文件目录
        $sPublic = $this->objProject->url_public;
        if (! $sPublic) {
            $sPublic = $sRoot . '/public';
        }
        
        // 快捷方法供 \Q::url 方法使用
        $GLOBALS ['~@url'] ['url_enter'] = $this->objProject->url_enter = $sEnter;
        $GLOBALS ['~@url'] ['url_root'] = $this->objProject->url_root = $sRoot;
        $GLOBALS ['~@url'] ['url_public'] = $this->objProject->url_public = $sPublic;
        
        unset ( $sEnter, $sEnterBak, $sRoot, $sPublic );
    }
    
    /**
     * 执行应用
     *
     * @return void
     */
    private function runApp_() {
        // 执行当前应用
        $strApp = $this->objRequest->app ();
        if (project::hasApp ( $strApp )) {
            return $this;
        }
        
        // 创建 & 注册
        project::registerApp ( ($objApp = $this->objProject->make('app', $strApp, $this->arrProjectOption)->run ()), $strApp );

        // 执行
        $objApp->app ();
    }
}
