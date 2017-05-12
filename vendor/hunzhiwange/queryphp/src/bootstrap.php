<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
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

/**
 * 框架引导文件
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2016.11.17
 * @version 1.0
 */
if (version_compare ( PHP_VERSION, '5.5.0', '<' ))
    die ( 'PHP 5.5.0 OR Higher' );

if (defined ( 'Q_VER' ))
    return;

ini_set ( 'default_charset', 'utf8' );

/**
 * QueryPHP 路径定义
 */
define ( 'Q_PATH', __DIR__ );

/**
 * QueryPHP 调试
 */
defined ( 'Q_DEBUG' ) or define ( 'Q_DEBUG', false );

/**
 * QueryPHP 开发环境
 * 开发模式 = development、测试环境 = testing、生产环境 production
 */
defined ( 'Q_DEVELOPMENT' ) or define ( 'Q_DEVELOPMENT', 'production' );

/**
 * QueryPHP 是否命令行工具模式
 */
defined ( 'Q_CONSOLE' ) or define ( 'Q_CONSOLE', false );
defined ( 'Q_PHPUNIT' ) or define ( 'Q_PHPUNIT', false );
defined ( 'Q_PHPUNIT_SYSTEM' ) or define ( 'Q_PHPUNIT_SYSTEM', false );

/**
 * QueryPHP 版本 | 2017.03.31
 */
define ( 'Q_VER', '4.0' );

/**
 * QueryPHP 自动载入
 */
require __DIR__ . '/psr4/psr4.php';
spl_autoload_register ( [ 
        'Q\psr4\psr4',
        'autoload' 
] );

/**
 * QueryPHP 注册框架命名空间
 */
Q\psr4\psr4::import ( 'Q', Q_PATH, [ 
        'ignore' => [ 
                'resource' 
        ] 
] );

/**
 * QueryPHP 系统错误处理
 */
if (PHP_SAPI != 'cli') {
    set_error_handler ( [ 
            'Q\exception\handle',
            'errorHandle' 
    ] );
    
    register_shutdown_function ( [ 
            'Q\exception\handle',
            'shutdownHandle' 
    ] );
}

if (! function_exists ( '__' )) {
    /**
     * 语言包
     *
     * @param string|null $sValue            
     * @return mixed
     */
    function __($sValue = null /*argvs*/ ){
        if (func_num_args () > 1) { // 代入参数
            $sValue = call_user_func_array ( 'sprintf', func_get_args () );
        }
        return $sValue;
    }
}

if (! function_exists ( 'project' )) {
    /**
     * 返回项目容器
     *
     * @param string|null $sInstance            
     * @return \Q\mvc\Q\mvc\project
     */
    function project($sInstance = null /*argvs*/) {
        if ($sInstance === null) {
            return \Q\mvc\project::bootstrap ();
        } else {
            $arrArgs = func_get_args ();
            array_shift ( $arrArgs );
            if (($objFacades = \Q\mvc\project::bootstrap ()->make ( $arrArgs ))) {
                return $objFacades;
            }
            \Q\exception\exceptions::badMethodCallException ( __ ( '未实现 facades 方法 %s', $sMethod ) );
        }
    }
}
