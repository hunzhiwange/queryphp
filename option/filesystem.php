<?php

declare(strict_types=1);

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

            // path
            'path' => Leevel::storagePath('attachments'),
        ],

        'zip' => [
            // driver
            'driver' => 'zip',

            // path
            'path' => Leevel::storagePath('attachments/filesystem.zip'),
        ],

        'ftp' => [
            // driver
            'driver' => 'ftp',

            // 主机
            'host' => Leevel::env('FILESYSTEM_FTP_HOST', 'ftp.example.com'),

            // 端口
            'port' => (int) Leevel::env('FILESYSTEM_FTP_PORT', 21),

            // 用户名
            'username' => Leevel::env('FILESYSTEM_FTP_USERNAME', 'your-username'),

            // 密码
            'password' => Leevel::env('FILESYSTEM_FTP_PASSWORD', 'your-password'),

            // 根目录
            'root' => '',

            // 被动、主动
            'passive' => true,

            // 加密传输
            'ssl' => false,

            // 超时设置
            'timeout' => 20,
        ],

        'sftp' => [
            // driver
            'driver' => 'sftp',

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
