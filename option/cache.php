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
     * 缓存时间预置
     * ---------------------------------------------------------------
     *
     * 为了满足不同的需求，有部分缓存键值需要的缓存时间不一致，有些缓存可能需要频繁更新
     * 于是这里我们可以通过配置缓存预设时间来控制缓存的键值的特殊时间，其中 * 表示通配符
     * 键值 = 缓存值，键值不带前缀,例如 ['option' => 60]
     */
    'time_preset' => [],

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

            // 文件缓存路径
            'path' => Leevel::runtimePath('file'),

            // 默认过期时间
            'expire' => null,
        ],

        'redis' => [
            // driver
            'driver' => 'redis',

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
        ],

        'redisPool' => [
            // driver
            'driver' => 'redisPool',

            // redis 连接
            'redis_connect' => 'redis',

            // 最小空闲连接池数据量
            'max_idle_connections' => (int) Leevel::env('CACHE_REDIS_POOL_MAX_IDLE_CONNECTIONS', 30),

            // 最大空闲连接池数据量
            'min_idle_connections' => (int) Leevel::env('CACHE_REDIS_POOL_MIN_IDLE_CONNECTIONS', 10),

            // 通道写入最大超时时间设置(单位为毫秒)
            'max_push_timeout' => -1000,

            // 通道获取最大等待超时(单位为毫秒)
            'max_pop_timeout' => 0,

            // 连接的存活时间(单位为毫秒)
            'keep_alive_duration' => 60000,

            // 最大尝试次数
            'retry_times' => 3,
        ],

        'file_throttler' => [
            // driver
            'driver' => 'file',

            // 文件缓存路径
            'path' => Leevel::runtimePath('throttler'),

            // 默认过期时间
            'expire' => null,
        ],

        'redis_throttler' => [
            // driver
            'driver' => 'redis',

            // 默认缓存服务器
            'host' => Leevel::env('THROTTLER_REDIS_HOST', '127.0.0.1'),

            // 默认缓存服务器端口
            'port' => (int) Leevel::env('THROTTLER_REDIS_PORT', 6379),

            // 认证密码
            'password' => Leevel::env('THROTTLER_REDIS_PASSWORD', ''),

            // redis 数据库索引
            'select' => 0,

            // 超时设置
            'timeout' => 0,

            // 是否使用持久连接
            'persistent' => false,

            // 默认过期时间
            'expire' => null,
        ],

        'file_session' => [
            // driver
            'driver' => 'file',

            // 文件缓存路径
            'path' => Leevel::runtimePath('session'),

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
