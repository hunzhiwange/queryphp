<?php

declare(strict_types=1);

/*
 * This file is part of the your app package.
 *
 * The PHP Application For Code Poem For You.
 * (c) 2018-2099 http://yourdomian.com All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [
    /*
     * ---------------------------------------------------------------
     * 默认数据库驱动
     * ---------------------------------------------------------------
     *
     * 系统为所有数据库驱动提供了统一的接口，在使用上拥有一致性
     */
    'default' => Leevel::env('DATABASE_DRIVER', 'mysql'),

    /*
     * ---------------------------------------------------------------
     * 数据库连接配置
     * ---------------------------------------------------------------
     *
     * 在模型实体或者数据库连接中指定的连接
     */
    'connect' => [
        'mysql' => [
            // driver
            'driver' => 'mysql',

            // 数据库 host，默认为 localhost
            'host' => Leevel::env('DATABASE_HOST', 'localhost'),

            // 端口
            'port' => (int) Leevel::env('DATABASE_PORT', 3306),

            // 数据库名字
            'name' => Leevel::env('DATABASE_NAME', ''),

            // 数据库用户名
            'user' => Leevel::env('DATABASE_USER', 'root'),

            // 数据库密码
            'password' => Leevel::env('DATABASE_PASSWORD', ''),

            // 数据库编码
            'charset' => 'utf8',

            // 连接参数
            'options' => [
                PDO::ATTR_PERSISTENT        => false,
                PDO::ATTR_CASE              => PDO::CASE_NATURAL,
                PDO::ATTR_ERRMODE           => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_ORACLE_NULLS      => PDO::NULL_NATURAL,
                PDO::ATTR_STRINGIFY_FETCHES => false,
                PDO::ATTR_EMULATE_PREPARES  => false,
            ],

            // 数据库读写是否分离
            'separate' => false,

            // 是否采用分布式
            'distributed' => false,

            // 分布式服务部署主服务器
            'master' => [],

            // 分布式服务部署模式中，附属服务器列表
            'slave' => [],
        ],
        'mysqlPool' => [
            // driver
            'driver' => 'mysqlPool',

            // mysql 连接
            'mysql_connect' => 'mysql',

            // 最小空闲连接池数据量
            'max_idle_connections' => (int) Leevel::env('DATABASE_MYSQL_POOL_MAX_IDLE_CONNECTIONS', 30),

            // 最大空闲连接池数据量
            'min_idle_connections' => (int) Leevel::env('DATABASE_MYSQL_POOL_MIN_IDLE_CONNECTIONS', 10),

            // 通道写入最大超时时间设置(单位为毫秒)
            'max_push_timeout' => -1000,

            // 通道获取最大等待超时(单位为毫秒)
            'max_pop_timeout' => 0,

            // 连接的存活时间(单位为毫秒)
            'keep_alive_duration' => 60000,

            // 最大尝试次数
            'retry_times' => 3,
        ],
    ],
];
