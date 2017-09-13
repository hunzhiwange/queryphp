<?php
// [$QueryPHP] The PHP Framework For Code Poem As Free As Wind. <Query Yet Simple>
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
 * 数据库默认配置文件
 *
 * @author Xiangmin Liu <635750556@qq.com>
 * @package $$
 * @since 2016.11.19
 * @version 1.0
 */
return [ 
        
        /**
         * ---------------------------------------------------------------
         * 默认数据库驱动
         * ---------------------------------------------------------------
         *
         * 系统为所有数据库驱动提供了统一的接口，在使用上拥有一致性
         */
        'default' => env ( 'database_driver', 'mysql' ),
        
        /**
         * ---------------------------------------------------------------
         * 数据库返回类型
         * ---------------------------------------------------------------
         *
         * 数据库查询结果类型，默认返回 stdClass 类型
         */
        'fetch' => PDO::FETCH_OBJ,
        
        /**
         * ---------------------------------------------------------------
         * 是否记录 SQL 日志
         * ---------------------------------------------------------------
         *
         * 是否记录系统运行过程中的 sql 日志信息
         * 同时 log\level 中必须包含 sql 允许的级别
         */
        'log' => true,
        
        /**
         * ---------------------------------------------------------------
         * 数据库连接配置
         * ---------------------------------------------------------------
         *
         * 在模型或者数据库连接中指定的连接
         */
        'connect' => [ 
                
                'mysql' => [
                        // driver
                        'driver' => 'mysql',
                        
                        // 数据库 host，默认为 localhost
                        'host' => env ( 'database_host', 'localhost' ),
                        
                        // 端口
                        'port' => env ( 'database_port', 3306 ),
                        
                        // 数据库名字
                        'name' => env ( 'database_name', '' ),
                        
                        // 数据库用户名
                        'user' => env ( 'database_user', 'root' ),
                        
                        // 数据库密码
                        'password' => env ( 'database_password', '' ),
                        
                        // 数据库编码
                        'charset' => 'utf8',
                        
                        // 连接参数
                        '+options' => [
                                
                                // 数据库是否支持长连接
                                PDO::ATTR_PERSISTENT => false 
                        ],
                        
                        // 数据库读写是否分离
                        'readwrite_separate' => false,
                        
                        // 是否采用分布式
                        'distributed' => false,
                        
                        // 分布式服务部署主服务器
                        'master' => [ ],
                        
                        // 分布式服务部署模式中，附属服务器列表
                        'slave' => [ ] 
                ] ,

                'data2' => [
                        // driver
                        'driver' => 'mysql',
                        
                        // 数据库 host，默认为 localhost
                        'host' => env ( 'database_host', 'localhost' ),
                        
                        // 端口
                        'port' => env ( 'database_port', 3307 ),
                        
                        // 数据库名字
                        'name' => 'queryphp_data_2',
                        
                        // 数据库用户名
                        'user' => 'root',
                        
                        // 数据库密码
                        'password' => env ( 'database_password', '123456' ),
                        
                        // 数据库编码
                        'charset' => 'utf8',
                        
                        // 连接参数
                        '+options' => [
                                
                                // 数据库是否支持长连接
                                PDO::ATTR_PERSISTENT => false 
                        ],
                        
                        // 数据库读写是否分离
                        'readwrite_separate' => false,
                        
                        // 是否采用分布式
                        'distributed' => false,
                        
                        // 分布式服务部署主服务器
                        'master' => [ ],
                        
                        // 分布式服务部署模式中，附属服务器列表
                        'slave' => [ ] 
                ] ,
                'data3' => [
                        // driver
                        'driver' => 'mysql',
                        
                        // 数据库 host，默认为 localhost
                        'host' => env ( 'database_host', 'localhost' ),
                        
                        // 端口
                        'port' => env ( 'database_port', 3307 ),
                        
                        // 数据库名字
                        'name' => 'queryphp_data_3',
                        
                        // 数据库用户名
                        'user' => 'root',
                        
                        // 数据库密码
                        'password' => env ( 'database_password', '123456' ),
                        
                        // 数据库编码
                        'charset' => 'utf8',
                        
                        // 连接参数
                        '+options' => [
                                
                                // 数据库是否支持长连接
                                PDO::ATTR_PERSISTENT => false 
                        ],
                        
                        // 数据库读写是否分离
                        'readwrite_separate' => false,
                        
                        // 是否采用分布式
                        'distributed' => false,
                        
                        // 分布式服务部署主服务器
                        'master' => [ ],
                        
                        // 分布式服务部署模式中，附属服务器列表
                        'slave' => [ ] 
                ] 
        ] 
];
