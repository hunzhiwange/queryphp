<?php
// (c) 2018 http://your.domain.com All rights reserved.

/**
 * ---------------------------------------------------------------
 * 版本支持最低 PHP 7.1.3
 * ---------------------------------------------------------------
 *
 * see http://php.net/manual/zh/migration71.php
 * see http://php.net/manual/zh/migration70.php
 */
version_compare(PHP_VERSION, '7.1.3', '<') && die('PHP 7.1.3 OR Higher');

/**
 * ---------------------------------------------------------------
 * 项目入口文件
 * ---------------------------------------------------------------
 *
 * 项目入口可以传递一些配置信息，具体信息请查阅文档
 */
require_once dirname(__DIR__) . '/vendor/autoload.php';
Leevel\Bootstrap\Project::singletons();
