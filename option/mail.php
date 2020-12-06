<?php

declare(strict_types=1);

return [
    /*
     * ---------------------------------------------------------------
     * 邮件驱动
     * ---------------------------------------------------------------
     *
     * 采用什么方式发送邮件数据
     */
    'default' => Leevel::env('MAIL_DRIVER', 'smtp'),

    /*
     * ---------------------------------------------------------------
     * 邮件发送地址
     * ---------------------------------------------------------------
     *
     * 必须设置邮件发送的邮箱
     */
    'global_from' => [
        'address' => Leevel::env('MAIL_GLOBAL_FROM_ADDRESS'),
        'name'    => Leevel::env('MAIL_GLOBAL_FROM_NAME'),
    ],

    /*
     * ---------------------------------------------------------------
     * 邮件全局接收地址
     * ---------------------------------------------------------------
     *
     * 这个可以不用设置，如果设置所有邮件都会发送一份到这个邮箱
     */
    'global_to' => [
        'address' => null,
        'name'    => null,
    ],

    /*
     * ---------------------------------------------------------------
     * 邮件驱动连接参数
     * ---------------------------------------------------------------
     *
     * 这里为所有的邮件驱动的连接参数，每一种不同的驱动拥有不同的配置
     * 虽然有不同的驱动，但是在使用上却有着一致性
     */
    'connect' => [
        'smtp' => [
            // driver
            'driver' => 'smtp',

            // smtp 主机
            'host' => Leevel::env('MAIL_HOST', 'smtp.qq.com'),

            // 端口
            'port' => (int) Leevel::env('MAIL_PORT', 587),

            // 用户名
            'username' => Leevel::env('MAIL_USERNAME'),

            // 登录密码
            'password' => Leevel::env('MAIL_PASSWORD'),

            // 加密方式
            'encryption' => Leevel::env('MAIL_ENCRYPTION', 'ssl'),
        ],

        'sendmail' => [
            // driver
            'driver' => 'sendmail',

            // 命令路径
            'path' => '/usr/sbin/sendmail -bs',
        ],

        'test' => [
            // driver
            'driver' => 'test',
        ],
    ],
];
