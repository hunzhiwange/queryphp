<?php
/*
 * [$MyApp] (C)QueryPHP.COM Since 2016.11.19.
 * 应用程序入口
 *
 * @author dyhb<635750556@qq.com>
 * @version $$
 * @date 2016.11.19
 * @since 1.0
 */

/**
 * 项目调试
 */
define ( 'Q_DEBUG', true );
define ( 'Q_DEVELOPMENT', 'develop' );

if (Q_DEVELOPMENT === 'develop')
    error_reporting ( E_ALL );
else
    error_reporting ( E_ERROR | E_PARSE | E_STRICT );

/**
 * 基础路径
 */
define ( 'PROJECT_PATH', dirname ( __DIR__ ) );

/**
 * 执行项目
 */
require_once PROJECT_PATH . '/lib/queryphp/run.php';
\Q\base\app::run ( [ 
        'project_path' => PROJECT_PATH 
] );