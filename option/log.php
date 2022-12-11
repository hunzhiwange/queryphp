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
     * 默认为 info、notice、warning、error、critical、alert 和 emergency
     */
    'levels' => [
        \Leevel\Log\ILog::LEVEL_EMERGENCY,
        \Leevel\Log\ILog::LEVEL_ALERT,
        \Leevel\Log\ILog::LEVEL_CRITICAL,
        \Leevel\Log\ILog::LEVEL_ERROR,
        \Leevel\Log\ILog::LEVEL_WARNING,
        \Leevel\Log\ILog::LEVEL_NOTICE,
        \Leevel\Log\ILog::LEVEL_INFO,
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

            // 存储 @see \Monolog\Handler\AbstractSyslogHandler
            'facility' => LOG_USER,

            // 等级
            'level' => \Leevel\Log\ILog::LEVEL_INFO,

            // 日志行事件格式化，支持微秒
            'format' => 'Y-m-d H:i:s u',
        ],
    ],
];
