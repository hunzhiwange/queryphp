<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace queryyetsimple\debug;

<<<queryphp
##########################################################
#   ____                          ______  _   _ ______   #
#  /     \       ___  _ __  _   _ | ___ \| | | || ___ \  #
# |   (  ||(_)| / _ \| '__|| | | || |_/ /| |_| || |_/ /  #
#  \____/ |___||  __/| |   | |_| ||  __/ |  _  ||  __/   #
#       \__   | \___ |_|    \__  || |    | | | || |      #
#     Query Yet Simple      __/  |\_|    |_| |_|\_|      #
#                          |___ /  Since 2010.10.03      #
##########################################################
queryphp;

use queryyetsimple\option\option;

/**
 * 调试
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.04.05
 * @version 4.0
 */
class console {

    /**
     * 记录调试信息
     * SQL 记录，加载文件等等
     *
     * @return void
     */
    public static function trace() {
        // ajax 不调试
        if(isset ( $_SERVER ['HTTP_X_REQUESTED_WITH'] ) && 'xmlhttprequest' == strtolower ( $_SERVER ['HTTP_X_REQUESTED_WITH'] ))
            return;
        
        // 调试信息
        if (Q_DEBUG === false || option::gets('debug\page_trace', false))
            return;
        
        $arrTrace = [ ];
        
        // SQL 记录
        // $arrLog = Log::$_arrLog;
        $arrLog = [ 
                'SELECT title FROM blog WHERE id = 1;' 
        ];
        if ($arrLog) {
            $arrTrace [__ ( 'SQL记录' ) . ' (' . count ( $arrLog ) . ')'] = implode ( '\n', $arrLog );
        }
        
        // 其它日志
        // $arrLog = Log::$_arrLog;
        $arrLog = [ ];
        if ($arrLog) {
            $arrTrace [__ ( '日志记录' ) . ' (' . count ( $arrLog ) . ')'] = '';
            $arrTrace = array_merge ( $arrTrace, $arrLog );
        }
        
        // 加载文件
        $arrInclude = get_included_files ();
        $arrTrace [__ ( '加载文件' ) . ' (' . count ( $arrInclude ) . ')'] = implode ( '\n', array_map ( function ($sVal) {
            return str_replace ( '\\', '/', $sVal );
        }, $arrInclude ) );
        
        include Q_PATH . '/resource/template/trace.php';
    }
}
