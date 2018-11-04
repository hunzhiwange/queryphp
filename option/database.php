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
            'port' => Leevel::env('DATABASE_PORT', 3306),

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
                // 数据库是否支持长连接
                PDO::ATTR_PERSISTENT => false,
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
    ],
];
