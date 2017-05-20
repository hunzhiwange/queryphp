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
        'enabled' => false, // 默认不记录日志
        'level' => 'error,sql,debug,info', // 允许记录的日志级别，随意自定义 error 和 sql 为系统内部使用
        'error_enabled' => false, // 是否记录系统中的错误日志
        'sql_enabled' => false, // 是否记录系统中的 sql 日志
        'file_size' => 2097152, // 日志文件大小限制
        'file_name' => 'Y-m-d H', // 日志文件名时间格式化
        'time_format' => '[Y-m-d H:i]', // 日志时间格式化
        'path_default' => '' // 默认路径
      
];
