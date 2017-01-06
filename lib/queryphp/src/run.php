<?php
/*
 * [$QueryPHP] (C)QueryPHP.COM Since 2016.11.17.
 * 基础初始化文件
 *
 * <The old is doyouhaobaby.com since 2010.10.04.>
 * @author dyhb<635750556@qq.com>
 * @version $$
 * @date 2016.11.17
 * @since 1.0
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
require_once Q_PATH . '/function.php';

/**
 * QueryPHP 自动载入
 */
require_once Q_PATH . '/autoload.php';
