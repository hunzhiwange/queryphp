<?php

declare(strict_types=1);

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
     * 默认为 info
     */
    'level' => [
        \Leevel\Log\ILog::DEFAULT_MESSAGE_CATEGORY => Leevel::env('LOG_DEFAULT_LEVEL', \Psr\Log\LogLevel::INFO),
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

            // 驱动类
            'driver_class' => \Leevel\Log\File::class,

            // 频道
            'channel' => null,

            // 日志文件名时间格式化
            // 使用 date 函数格式化处理
            'name' => 'Y-m-d',

            // 默认的日志路径
            'path' => Leevel::storagePath('logs'),

            // 日志行时间格式化，支持微秒
            'format' => 'Y-m-d H:i:s u',

            // 日志文件权限
            'file_permission' => null,

            // 是否使用锁
            'use_locking' => false,
        ],

        'syslog' => [
            // driver
            'driver' => 'syslog',

            // 驱动类
            'driver_class' => \Leevel\Log\Syslog::class,

            // 频道
            'channel' => null,

            // 存储 \Monolog\Handler\AbstractSyslogHandler
            'facility' => LOG_USER,

            // 日志行事件格式化，支持微秒
            'format' => 'Y-m-d H:i:s u',
        ],
    ],
];
