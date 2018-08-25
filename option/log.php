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
     * 默认日志驱动
     * ---------------------------------------------------------------
     *
     * 系统为所有日志提供了统一的接口，在使用上拥有一致性
     */
    'default' => Leevel::env('log_driver', 'file'),

    /*
     * ---------------------------------------------------------------
     * 允许记录的日志级别
     * ---------------------------------------------------------------
     *
     * 随意自定义,其中 debug、info、notice、warning、error、critical、alert、emergency 和 sql 为系统内部使用
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
    'channel' => Leevel::environment(),

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
            'level' => ILog::DEBUG,
        ],
    ],
];
