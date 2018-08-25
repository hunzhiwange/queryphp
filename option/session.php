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
     * session 驱动
     * ---------------------------------------------------------------
     *
     * 采用什么源保存 session 数据，默认采用文件
     */
    'default' => Leevel::env('session_driver', 'file'),

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
     * 为了与下面的配置 expire 对应，这里没有设置为 cache_expire
     * session_cache_expire ( expire )
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

            // 是否 serialize 格式化
            'serialize' => true,

            // 默认过期时间
            'expire' => null,
        ],

        'redis' => [
            // driver
            'driver' => 'redis',

            // 默认缓存服务器
            'host' => Leevel::env('session_redis_host', '127.0.0.1'),

            // 默认缓存服务器端口
            'port' => Leevel::env('session_redis_port', 6379),

            // 认证密码
            'password' => Leevel::env('session_redis_password', ''),

            // redis 数据库索引
            'select' => 0,

            // 超时设置
            'timeout' => 0,

            // 是否使用持久连接
            'persistent' => false,

            // 是否使用 serialize 编码
            'serialize' => true,

            // 默认过期时间
            'expire' => null,
        ],

        'nulls' => [
            // driver
            'driver' => 'nulls',
        ],
    ],
];
