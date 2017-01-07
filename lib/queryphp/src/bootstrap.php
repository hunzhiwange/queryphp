<?php
/*
 * [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
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
if (version_compare ( PHP_VERSION, '5.3.0', '<' ))
    die ( 'PHP5.3 OR Higher' );

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
 * QueryPHP 版本 | 2016.11.17
 */
define ( 'Q_VER', '1.0' );

/**
 * QueryPHP 核心函数库和一些公用函数
 */
require_once Q_PATH . '/base/queryphp.php';

/**
 * QueryPHP 自动载入
 */
require_once Q_PATH . '/autoload.php';
