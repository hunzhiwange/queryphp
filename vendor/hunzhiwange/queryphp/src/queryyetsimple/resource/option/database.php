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
         * 数据库
         */
        
        // 数据库默认连接参数
        'type' => 'mysql', // 数据库类型
        'host' => 'localhost', // 数据库地址
        'user' => 'root', // 数据库用户名
        'password' => '', // 数据库密码
        'prefix' => '', // 数据库表前缀
        'char' => 'utf8', // 数据库编码
        'name' => '', // 数据库名字
        'schema' => '', // 数据库SCHEMA
        'port' => 3306, // 端口
        'dsn' => '', // [优先解析]数据 dsn 解析 mysql://username:password@localhost:3306/dbname
        'params' => [ ], // 数据库连接参数
        'persistent' => false, // 数据库是否支持长连接
        'distributed' => false, // 是否采用分布式
        'rw_separate' => false, // 数据库读写是否分离[注意：主从式有效]
        'master' => [ ], // 主服务器
        'slave' => [ ], // 副服务器
                           
        // 数据库缓存
        'cache' => false, // 数据库查询是否缓存
        'meta_cached' => true, // 数据库元是否缓存
    
];
