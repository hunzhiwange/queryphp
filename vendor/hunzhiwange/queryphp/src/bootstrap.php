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
 * @date 2016.11.17
 * @since 1.0
 */

/**
 * 框架引导文件
 *
 * @author Xiangmin Liu
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
 * QueryPHP 开发模式
 * 开发模式=develop、测试模式=test、线上模式online
 */
defined ( 'Q_DEVELOPMENT' ) or define ( 'Q_DEVELOPMENT', 'online' );

/**
 * QueryPHP 版本 | 2017.03.31
 */
define ( 'Q_VER', '4.0' );

/**
 * QueryPHP 核心函数库和一些公用函数
 */
require_once Q_PATH . '/mvc/queryphp.php';

/**
 * QueryPHP 系统警告处理
 */
set_exception_handler ( [ 
        'Q',
        'exceptionHandler' 
] );

/**
 * QueryPHP 系统错误处理
 */
if (Q_DEBUG === TRUE) {
    set_error_handler ( [ 
            'Q',
            'errorHandel' 
    ] );
    
    register_shutdown_function ( [ 
            'Q',
            'shutdownHandel' 
    ] );
}

/**
 * QueryPHP 自动载入
 */
spl_autoload_register ( [ 
        'Q',
        'autoload' 
] );

/**
 * QueryPHP 注册框架命名空间
 */
\Q::import ( 'Q', Q_PATH, [ 
        'ignore' => [ 
                'resource' 
        ] 
] );
