<?php

declare(strict_types=1);

return [
    /*
     * ---------------------------------------------------------------
     * 默认认证类型
     * ---------------------------------------------------------------
     *
     * 这里可以是 web 或者 api
     */
    'default' => 'api',

    /*
     * ---------------------------------------------------------------
     * 默认 WEB 驱动
     * ---------------------------------------------------------------
     *
     * WEB 认证驱动连接
     */
    'web_default' => 'session',

    /*
     * ---------------------------------------------------------------
     * 默认 API 驱动
     * ---------------------------------------------------------------
     *
     * API 认证驱动连接
     */
    'api_default' => 'token',

    /*
     * ---------------------------------------------------------------
     * 认证默认过期时间
     * ---------------------------------------------------------------
     *
     * 设置好过期时间，超过这个时间系统会重新要求认证, 小与等于 0 表示永不过期
     * 过期时间为当前时间加上以秒为单位的数量
     */
    'expire' => (int) Leevel::env('AUTH_EXPIRE', 2592000),

    /*
     * ---------------------------------------------------------------
     * auth 连接参数
     * ---------------------------------------------------------------
     *
     * 这里为所有的 auth 的连接参数，每一种不同的驱动拥有不同的配置
     * 虽然有不同的驱动，但是在验证使用上却有着一致性
     */
    'connect' => [
        'session' => [
            // driver
            'driver' => 'session',

            // token
            'token' => 'token',

            // 默认过期时间
            'expire' => null,
        ],

        'token' => [
            // driver
            'driver' => 'token',

            // token，需要从接口传入进来
            'token' => null,

            // 默认过期时间
            'expire' => null,
        ],
    ],
];
