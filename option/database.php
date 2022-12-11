<?php

declare(strict_types=1);

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

            // 驱动类
            'driver_class' => \Leevel\Database\Mysql::class,

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
                PDO::ATTR_ORACLE_NULLS      => PDO::NULL_NATURAL,
                PDO::ATTR_STRINGIFY_FETCHES => false,
                PDO::ATTR_EMULATE_PREPARES  => false,
                PDO::ATTR_TIMEOUT           => 30,
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
