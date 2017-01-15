<?php

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
require_once PROJECT_PATH . '/lib/queryphp/src/bootstrap.php';
\Q\mvc\project::run ( [ 
        'project_path' => PROJECT_PATH 
] );