<?php
/*
 * [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @version $$
 * @date 2016.11.18
 * @since 1.0
 */

/**
 * 自动载入、接管系统异常
 * 
 * @author Xiangmin Liu
 */
namespace Q;

/**
 * 系统警告处理
 */
set_exception_handler ( [ 
        'Q',
        'exceptionHandler' 
] );

/**
 * 系统错误处理
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
 * 自动载入
 */
if (function_exists ( 'spl_autoload_register' )) {
    spl_autoload_register ( [ 
            'Q',
            'autoload' 
    ] );
} else {
    function __autoload($sClassName) {
        Q::autoLoad ( $sClassName );
    }
}
