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
     * 默认日志驱动
     * ---------------------------------------------------------------
     *
     * 系统为所有日志提供了统一的接口，在使用上拥有一致性
     */
    'default' => Leevel::env('LOG_DRIVER', 'file'),

    /*
     * ---------------------------------------------------------------
     * 允许记录的日志级别
     * ---------------------------------------------------------------
     *
     * 默认为 debug、info、notice、warning、error、critical、alert 和 emergency
     */
    'levels' => [
        'debug',
        'info',
        'notice',
        'warning',
        'error',
        'critical',
        'alert',
        'emergency',
    ],

    /*
     * ---------------------------------------------------------------
     * 频道
     * ---------------------------------------------------------------
     *
     * 隔离不同环境的日志
     */
    'channel' => Leevel::env('ENVIRONMENT', 'development'),

    /*
     * ---------------------------------------------------------------
     * 是否启用缓冲
     * ---------------------------------------------------------------
     *
     * 启用缓冲可以降低磁盘或网络的 IO 请求以提升性能
     */
    'buffer' => true,

    /*
     * ---------------------------------------------------------------
     * 缓冲数量
     * ---------------------------------------------------------------
     *
     * 日志数量达到缓冲数量会执行一次 IO 操作
     */
    'buffer_size' => 100,

    /*
     * ---------------------------------------------------------------
     * 日志连接参数
     * ---------------------------------------------------------------
     *
     * 这里为所有的日志的连接参数，每一种不同的驱动拥有不同的配置
     * 虽然有不同的驱动，但是在日志使用上却有着一致性
     */
    'connect' => [
        'file' => [
            // driver
            'driver' => 'file',

            // 频道
            'channel' => null,

            // 日志文件名时间格式化
            'name' => 'Y-m-d H',

            // 日志文件大小限制,单位为字节 byte
            'size' => 2097152,

            // 默认的日志路径
            'path' => Leevel::runtimePath('log'),
        ],

        'syslog' => [
            // driver
            'driver' => 'syslog',

            // 频道
            'channel' => null,

            // 存储 @see \Monolog\Handler\AbstractSyslogHandler
            'facility' => LOG_USER,

            // 等级
            'level' => 'debug',
        ],
    ],
];
