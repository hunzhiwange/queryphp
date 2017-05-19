<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace queryyetsimple\exception;

<<<queryphp
##########################################################
#   ____                          ______  _   _ ______   #
#  /       \       ___  _ __  _   _ | ___ \| | | || ___ \  #
# |     (     ||(_)| / _ \| '__|| | | || |_/ /| |_| || |_/ /  #
#  \____/ |___||  __/| |   | |_| ||  __/ |  _  ||  __/   #
#       \__   | \___ |_|    \__  || |    | | | || |      #
#     Query Yet Simple      __/  |\_|    |_| |_|\_|      #
#                          |___ /  Since 2010.10.03      #
##########################################################
queryphp;

/**
 * 异常响应
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.04.09
 * @version 4.0
 */
class handle {
    
    /**
     * 接管 PHP 异常
     *
     * @param Exception $oException            
     * @return void
     */
    public static function exceptionHandle($oException) {
        (new exception_message ( $oException ))->run ();
        exit ();
    }
    
    /**
     * 接管 PHP 错误
     *
     * @param int $nErrorNo            
     * @param string $sErrStr            
     * @param string $sErrFile            
     * @param int $nErrLine            
     * @return void
     */
    public static function errorHandle($nErrorNo, $sErrStr, $sErrFile, $nErrLine) {
        (new error_message ( $nErrorNo, $sErrStr, $sErrFile, $nErrLine ))->run ();
        exit ();
    }
    
    /**
     * 接管 PHP 致命错误
     *
     * @return void
     */
    public static function shutdownHandle() {
        (new shutdown_message ())->run ();
        exit ();
    }
}
