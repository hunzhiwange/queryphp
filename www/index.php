<?php
/**
 * 项目调试
 */
define ( 'Q_DEBUG', true );
define ( 'Q_DEVELOPMENT', 'development' );

if (Q_DEVELOPMENT === 'development')
    error_reporting ( E_ALL );
else
    error_reporting ( E_ERROR | E_PARSE | E_STRICT );

/**
 * 基础路径
 */
define ( 'PATH', dirname ( __DIR__ ) );

/**
 * 执行项目
 */
require_once PATH . '/vendor/hunzhiwange/queryphp/src/queryyetsimple/bootstrap.php';
\queryyetsimple\mvc\project::bootstrap ( PATH )->run ();
