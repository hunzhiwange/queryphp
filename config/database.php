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
            'configs' => [
                PDO::ATTR_PERSISTENT => false,
                PDO::ATTR_CASE => PDO::CASE_NATURAL,
                PDO::ATTR_ORACLE_NULLS => PDO::NULL_NATURAL,
                PDO::ATTR_STRINGIFY_FETCHES => false,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_TIMEOUT => 30,
            ],

            // 数据库读写是否分离
            'separate' => false,

            // 是否采用分布式
            'distributed' => false,

            // 如果该配置项设置为 true 的话，在同一个事务中，写入的数据会被立刻读取到
            // 同时，该配置也兼容阿里云 RDS MySQL
            // RDS MySQL 读写分离如何确保数据读取的时效性
            // https://help.aliyun.com/zh/rds/support/how-do-i-ensure-the-timeliness-of-reading-data-on-an-apsaradb-rds-for-mysql-instance-when-the-read-or-write-splitting-feature-is-enabled
            'strict' => true,

            // 分布式服务部署主服务器
            'master' => [],

            // 分布式服务部署模式中，附属服务器列表
            'slave' => [],

            // 启用连接池功能
            // 连接池紧紧在 Swoole 环境下面生效
            // 最大空闲连接池数据量
            'max_idle_connections' => (int) Leevel::env('DATABASE_MYSQL_POOL_MAX_IDLE_CONNECTIONS', 60),

            // 通道写入最大超时时间设置(单位为秒,支持小数)
            'max_push_timeout' => (float) Leevel::env('DATABASE_MYSQL_POOL_MAX_POP_TIMEOUT', -1),

            // 通道获取最大等待超时(单位为秒,支持小数)
            'max_pop_timeout' => (float) Leevel::env('DATABASE_MYSQL_POOL_MAX_PUSH_TIMEOUT', -1),

            // 连接的存活时间(单位为秒)
            'keep_alive_duration' => (int) Leevel::env('DATABASE_MYSQL_POOL_KEEP_ALIVE_DURATION', 60),
        ],
        'common' => [
            // driver
            'driver' => 'mysql',

            // 数据库 host，默认为 localhost
            'host' => Leevel::env('DATABASE_COMMON_HOST', 'localhost'),

            // 端口
            'port' => (int) Leevel::env('DATABASE_COMMON_PORT', 3306),

            // 数据库名字
            'name' => Leevel::env('DATABASE_COMMON_NAME', ''),

            // 数据库用户名
            'user' => Leevel::env('DATABASE_COMMON_USER', 'root'),

            // 数据库密码
            'password' => Leevel::env('DATABASE_COMMON_PASSWORD', ''),
        ],
    ],
];
