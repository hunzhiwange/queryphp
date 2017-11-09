<?php
// ©2017 http://your.domain.com All rights reserved.

/**
 * ---------------------------------------------------------------
 * 项目入口文件
 * ---------------------------------------------------------------
 *
 * 读取 Composer Autoload 并注入框架
 * 项目入口可以传递一些配置信息，具体信息请查阅文档
 * see http://www.queryphp.com/v4/execution-flow/single-entry-index.php.html
 */
$oComposer = require dirname ( __DIR__ ) . '/vendor/autoload.php';
queryyetsimple\bootstrap\project::singletons ( $oComposer, [ ] );
