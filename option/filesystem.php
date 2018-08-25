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
     * filesystem 驱动
     * ---------------------------------------------------------------
     *
     * 采用什么方式发送邮件数据
     */
    'default' => Leevel::env('filesystem_driver', 'local'),

    /*
     * ---------------------------------------------------------------
     * filesystem 驱动连接参数
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
            'path' => Leevel::storagePath(),
        ],

        'zip' => [
            // driver
            'driver' => 'zip',

            // path
            'path' => Leevel::storagePath('filesystem.zip'),
        ],

        'ftp' => [
            // driver
            'driver' => 'ftp',

            // 主机
            'host' => Leevel::env('filesystem_ftp_host', 'ftp.example.com'),

            // 端口
            'port' => Leevel::env('filesystem_ftp_port', 21),

            // 用户名
            'username' => Leevel::env('filesystem_ftp_username', 'your-username'),

            // 密码
            'password' => Leevel::env('filesystem_ftp_password', 'your-password'),

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
            'host' => Leevel::env('filesystem_sftp_host', 'sftp.example.com'),

            // 端口
            'port' => Leevel::env('filesystem_sftp_port', 22),

            // 用户名
            'username' => Leevel::env('filesystem_sftp_username', 'your-username'),

            // 密码
            'password' => Leevel::env('filesystem_sftp_password', 'your-password'),

            // 根目录
            'root' => '',

            // 私钥路径
            'privateKey' => '',

            // 超时设置
            'timeout' => 20,
        ],
    ],
];
