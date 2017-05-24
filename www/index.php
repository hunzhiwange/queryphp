<?php

/**
 * 基础路径
 */
define ( 'PATH', dirname ( __DIR__ ) );

/**
 * 执行项目
 */
$objComposer = require PATH. '/vendor/autoload.php';
queryyetsimple\mvc\project::bootstrap ( $objComposer )->run ();
