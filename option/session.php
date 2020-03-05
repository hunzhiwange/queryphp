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
     * expire
     * ---------------------------------------------------------------
     *
     * 默认过期时间
     */
    'expire' => 86400,

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

            // 文件缓存路径
            'path' => Leevel::runtimePath('session'),

            // 默认过期时间
            'expire' => null,
        ],

        'redis' => [
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

        'test' => [
            // driver
            'driver' => 'test',
        ],
    ],
];
