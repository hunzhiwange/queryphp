<?php
// (c) 2018 http://your.domain.com All rights reserved.

/**
 * ---------------------------------------------------------------
 * 版本支持最低 PHP 7.1
 * ---------------------------------------------------------------
 *
 * see http://php.net/manual/zh/migration71.php
 * see http://php.net/manual/zh/migration70.php
 */
version_compare(PHP_VERSION, '7.1.0', '<') && die('PHP 7.1.0 OR Higher');

/**
 * ---------------------------------------------------------------
 * 项目入口文件
 * ---------------------------------------------------------------
 *
 * 读取 Composer Autoload 并注入框架
 * 项目入口可以传递一些配置信息，具体信息请查阅文档
 * see http://www.queryphp.com/v4/execution-flow/single-entry-index.php.html
 */
$composer = require_once dirname(__DIR__) . '/vendor/autoload.php';
Queryyetsimple\Bootstrap\Project::singletons($composer);
