<?php
// (c) 2018 http://your.domain.com All rights reserved.

/**
 * filesystem 默认配置文件
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.08.29
 * @version 1.0
 */
return [

    /**
     * ---------------------------------------------------------------
     * filesystem 驱动
     * ---------------------------------------------------------------
     *
     * 采用什么方式发送邮件数据
     */
    'default' => env('filesystem_driver', 'local'),

    /**
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
            'path' => path_storage()
        ],

        'zip' => [
            // driver
            'driver' => 'zip',

            // path
            'path' => path_storage('filesystem.zip')
        ],

        'ftp' => [
            // driver
            'driver' => 'ftp',

            // 主机
            'host' => env('filesystem_ftp_host', 'ftp.example.com'),

            // 端口
            'port' => env('filesystem_ftp_port', 21),

            // 用户名
            'username' => env('filesystem_ftp_username', 'your-username'),

            // 密码
            'password' => env('filesystem_ftp_password', 'your-password'),

            // 根目录
            'root' => '',

            // 被动、主动
            'passive' => true,

            // 加密传输
            'ssl' => false,

            // 超时设置
            'timeout' => 20
        ],

        'sftp' => [
            // driver
            'driver' => 'sftp',

            // 主机
            'host' => env('filesystem_sftp_host', 'sftp.example.com'),

            // 端口
            'port' => env('filesystem_sftp_port', 22),

            // 用户名
            'username' => env('filesystem_sftp_username', 'your-username'),

            // 密码
            'password' => env('filesystem_sftp_password', 'your-password'),

            // 根目录
            'root' => '',

            // 私钥路径
            'privateKey' => '',

            // 超时设置
            'timeout' => 20
        ]
    ]
];
