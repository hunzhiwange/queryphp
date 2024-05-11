<?php

declare(strict_types=1);
use Leevel\Filesystem\Local;
use Leevel\Filesystem\Sftp;
use Leevel\Filesystem\Zip;

return [
    /*
     * ---------------------------------------------------------------
     * 文件驱动
     * ---------------------------------------------------------------
     *
     * 采用什么方式发送邮件数据
     */
    'default' => Leevel::env('FILESYSTEM_DRIVER', 'local'),

    /*
     * ---------------------------------------------------------------
     * 文件驱动连接参数
     * ---------------------------------------------------------------
     *
     * 这里为所有的 filesystem 驱动的连接参数，每一种不同的驱动拥有不同的配置
     * 虽然有不同的驱动，但是在使用上却有着一致性
     */
    'connect' => [
        'local' => [
            // driver
            'driver' => 'local',

            // 驱动类
            'driver_class' => Local::class,

            // path
            'path' => Leevel::path('www/attachments'),
        ],

        'zip' => [
            // driver
            'driver' => 'zip',

            // 驱动类
            'driver_class' => Zip::class,

            // path
            'path' => Leevel::path('www/attachments/filesystem.zip'),
        ],

        'sftp' => [
            // driver
            'driver' => 'sftp',

            // 驱动类
            'driver_class' => Sftp::class,

            // 主机
            'host' => Leevel::env('FILESYSTEM_SFTP_HOST', 'sftp.example.com'),

            // 端口
            'port' => (int) Leevel::env('FILESYSTEM_SFTP_PORT', 22),

            // 用户名
            'username' => Leevel::env('FILESYSTEM_SFTP_USERNAME', 'your-username'),

            // 密码
            'password' => Leevel::env('FILESYSTEM_SFTP_PASSWORD', 'your-password'),

            // 根目录
            'root' => '',

            // 私钥路径
            'privateKey' => '',

            // 超时设置
            'timeout' => 20,
        ],
    ],
];
