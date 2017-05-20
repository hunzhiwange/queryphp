<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
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

/**
 * 系统默认配置文件
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2016.11.19
 * @version 1.0
 */
return [ 
        
        /**
         * 日志 && 调试
         */
        'page_trace' => false, // 显示页面调式信息
        
        'exception_handle' => [
                'queryyetsimple\exception\handle',
                'exceptionHandle'
        ], // 异常捕获
        
        'exception_redirect' => '', // 重定向错误页面
        'exception_template' => '', // 自定义错误模板
        'exception_default_message' => 'error', // 默认异常错误消息
        'exception_show_message' => true, // 是否显示具体错误
]; // memcache 是否使用持久连接
