<?php

declare(strict_types=1);

return [
    /*
     * ---------------------------------------------------------------
     * 默认缓存驱动
     * ---------------------------------------------------------------
     *
     * 这里可以可以设置为 file、memcache 等
     * 系统为所有缓存提供了统一的接口，在使用上拥有一致性
     */
    'default' => Leevel::env('CACHE_DRIVER', 'file'),

    /*
     * ---------------------------------------------------------------
     * 程序默认缓存时间
     * ---------------------------------------------------------------
     *
     * 设置好缓存时间，超过这个时间系统缓存会重新进行获取, 小与等于 0 表示永不过期
     * 缓存时间为当前时间加上以秒为单位的数量
     */
    'expire' => (int) Leevel::env('CACHE_EXPIRE', 86400),

    /*
     * ---------------------------------------------------------------
     * 缓存连接参数
     * ---------------------------------------------------------------
     *
     * 这里为所有的缓存的连接参数，每一种不同的驱动拥有不同的配置
     * 虽然有不同的驱动，但是在缓存使用上却有着一致性
     */
    'connect' => [
        'file' => [
            // driver
            'driver' => 'file',

            // 驱动类
            'driver_class' => \Leevel\Cache\File::class,

            // 文件缓存路径
            'path' => Leevel::storagePath('app/cache'),

            // 默认过期时间
            'expire' => null,
        ],

        'redis' => [
            // driver
            'driver' => 'redis',

            // 驱动类
            'driver_class' => \Leevel\Cache\Redis::class,

            // 默认缓存服务器
            'host' => Leevel::env('CACHE_REDIS_HOST', '127.0.0.1'),

            // 默认缓存服务器端口
            'port' => (int) Leevel::env('CACHE_REDIS_PORT', 6379),

            // 认证密码
            'password' => Leevel::env('CACHE_REDIS_PASSWORD', ''),

            // redis 数据库索引
            'select' => 0,

            // 超时设置
            'timeout' => 0,

            // 是否使用持久连接
            'persistent' => false,

            // 默认过期时间
            'expire' => null,

            // 启用连接池功能
            // 连接池紧紧在 Swoole 环境下面生效
            // 最大空闲连接池数据量
            'max_idle_connections' => (int) Leevel::env('CACHE_REDIS_POOL_MAX_IDLE_CONNECTIONS', 60),

            // 通道写入最大超时时间设置(单位为秒,支持小数)
            'max_push_timeout' => (float) Leevel::env('CACHE_REDIS_POOL_MAX_POP_TIMEOUT', -1),

            // 通道获取最大等待超时(单位为秒,支持小数)
            'max_pop_timeout' => (float) Leevel::env('CACHE_REDIS_POOL_MAX_PUSH_TIMEOUT', -1),

            // 连接的存活时间(单位为秒)
            'keep_alive_duration' => (int) Leevel::env('CACHE_REDIS_POOL_KEEP_ALIVE_DURATION', 60),
        ],

        'file_session' => [
            // driver
            'driver' => 'file',

            // 文件缓存路径
            'path' => Leevel::storagePath('app/sessions'),

            // 默认过期时间
            'expire' => null,
        ],

        'redis_session' => [
            // driver
            'driver' => 'redis',

            // 默认缓存服务器
            'host' => Leevel::env('SESSION_REDIS_HOST', '127.0.0.1'),

            // 默认缓存服务器端口
            'port' => (int) Leevel::env('SESSION_REDIS_PORT', 6379),

            // 认证密码
            'password' => Leevel::env('SESSION_REDIS_PASSWORD', ''),

            // redis 数据库索引
            'select' => 0,

            // 超时设置
            'timeout' => 0,

            // 是否使用持久连接
            'persistent' => false,

            // 默认过期时间
            'expire' => null,
        ],
    ],
];
