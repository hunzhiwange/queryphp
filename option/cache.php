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
     * 设置好缓存时间，超过这个时间系统缓存会重新进行获取, -1 表示永不过期
     * 缓存时间为当前时间加上以秒为单位的数量
     */
    'expire' => 86400,

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

            // 是否 serialize 格式化
            'serialize' => true,

            // 默认过期时间
            'expire' => null,
        ],

        'redis' => [
            // driver
            'driver' => 'redis',

            // 默认缓存服务器
            'host' => Leevel::env('CACHE_REDIS_HOST', '127.0.0.1'),

            // 默认缓存服务器端口
            'port' => Leevel::env('CACHE_REDIS_PORT', 6379),

            // 认证密码
            'password' => Leevel::env('CACHE_REDIS_PASSWORD', ''),

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
    ],
];
