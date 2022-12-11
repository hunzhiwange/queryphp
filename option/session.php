<?php

declare(strict_types=1);

return [
    /*
     * ---------------------------------------------------------------
     * session 驱动
     * ---------------------------------------------------------------
     *
     * 采用什么源保存 session 数据，默认采用文件
     */
    'default' => Leevel::env('SESSION_DRIVER', 'file'),

    /*
     * ---------------------------------------------------------------
     * id
     * ---------------------------------------------------------------
     *
     * 相当于 session_id
     * null 表示自动生成随机字符串
     */
    'id' => null,

    /*
     * ---------------------------------------------------------------
     * name
     * ---------------------------------------------------------------
     *
     * 相当于 session_name
     */
    'name' => 'UID',

    /*
     * ---------------------------------------------------------------
     * COOKIE 过期时间
     * ---------------------------------------------------------------
     *
     * SESSION 依赖 COOKIE
     * COOKIE 默认过期时间
     * 小于等于 0 表示关闭浏览器即失效
     */
    'cookie_expire' => 86400,

    /*
     * ---------------------------------------------------------------
     * session 驱动连接参数
     * ---------------------------------------------------------------
     *
     * 这里为所有的 session 驱动的连接参数，每一种不同的驱动拥有不同的配置
     * 虽然有不同的驱动，但是在使用上却有着一致性
     */
    'connect' => [
        'file' => [
            // driver
            'driver' => 'file',

            // 驱动类
            'driver_class' => \Leevel\Session\File::class,

            // 文件缓存驱动
            'file_driver' => Leevel::env('SESSION_FILE_DRIVER', 'file_session'),
        ],

        'redis' => [
            // driver
            'driver' => 'redis',

            // 驱动类
            'driver_class' => \Leevel\Session\Redis::class,

            // Redis 缓存驱动
            'redis_driver' => Leevel::env('SESSION_REDIS_DRIVER', 'redis_session'),
        ],

        'test' => [
            // driver
            'driver' => 'test',

            // 驱动类
            'driver_class' => \Leevel\Session\Test::class,
        ],
    ],
];
