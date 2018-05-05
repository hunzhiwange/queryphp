<?php declare(strict_types=1);
// (c) 2018 http://your.domain.com All rights reserved.

/**
 * auth 默认配置文件
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.09.07
 * @version 1.0
 */
return [

    /**
     * ---------------------------------------------------------------
     * 默认认证类型
     * ---------------------------------------------------------------
     *
     * 这里可以是 web 或者 api
     */
    'default' => 'web',

    /**
     * ---------------------------------------------------------------
     * 默认 WEB 驱动
     * ---------------------------------------------------------------
     *
     * WEB 认证驱动连接
     */
    'web_default' => 'session',

    /**
     * ---------------------------------------------------------------
     * 默认 API 驱动
     * ---------------------------------------------------------------
     *
     * API 认证驱动连接
     */
    'api_default' => 'token',

    /**
     * ---------------------------------------------------------------
     * auth 连接参数
     * ---------------------------------------------------------------
     *
     * 这里为所有的 auth 的连接参数，每一种不同的驱动拥有不同的配置
     * 虽然有不同的驱动，但是在日志使用上却有着一致性
     */
    'connect' => [
        'session' => [
            // driver
            'driver' => 'session',

            // 模型
            'model' => common\domain\entity\user::class,

            // 用户信息持久化名字
            'user_persistence' => 'user_persistence',

            // Token 持久化名字
            'token_persistence' => 'token_persistence',

            // 查询字段
            'field' => 'id,name,nikename,email,mobile'
        ],

        'token' => [
            // driver
            'driver' => 'token',

            // 模型
            'model' => common\domain\entity\user::class,

            // 用户信息持久化名字
            'user_persistence' => 'user_persistence',

            // Token 持久化名字
            'token_persistence' => 'token_persistence',

            // 查询字段
            'field' => 'id,name,nikename,email,mobile'
        ]
    ]
];
