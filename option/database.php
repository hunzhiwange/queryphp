<?php

declare(strict_types=1);

/*
 * This file is part of the forcodepoem package.
 *
 * The PHP Application Created By Code Poem. <Query Yet Simple>
 * (c) 2018-2099 http://forcodepoem.com All rights reserved.
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
    'default' => Leevel::env('database_driver', 'mysql'),

    /*
     * ---------------------------------------------------------------
     * 数据库返回类型
     * ---------------------------------------------------------------
     *
     * 数据库查询结果类型，默认返回 stdClass 类型
     */
    'fetch' => PDO::FETCH_OBJ,

    /*
     * ---------------------------------------------------------------
     * 是否记录 SQL 日志
     * ---------------------------------------------------------------
     *
     * 是否记录系统运行过程中的 sql 日志信息
     * 同时 log\level 中必须包含 sql 允许的级别
     */
    'log' => true,

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
            'host' => Leevel::env('database_host', 'localhost'),

            // 端口
            'port' => Leevel::env('database_port', 3306),

            // 数据库名字
            'name' => Leevel::env('database_name', ''),

            // 数据库用户名
            'user' => Leevel::env('database_user', 'root'),

            // 数据库密码
            'password' => Leevel::env('database_password', ''),

            // 数据库编码
            'charset' => 'utf8',

            // 连接参数
            'options' => [
                // 数据库是否支持长连接
                PDO::ATTR_PERSISTENT => false,
            ],

            // 数据库读写是否分离
            'readwrite_separate' => false,

            // 是否采用分布式
            'distributed' => false,

            // 分布式服务部署主服务器
            'master' => [],

            // 分布式服务部署模式中，附属服务器列表
            'slave' => [],
        ],
    ],
];
