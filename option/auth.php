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
     * 默认认证类型
     * ---------------------------------------------------------------
     *
     * 这里可以是 web 或者 api
     */
    'default' => 'web',

    /*
     * ---------------------------------------------------------------
     * 默认 WEB 驱动
     * ---------------------------------------------------------------
     *
     * WEB 认证驱动连接
     */
    'web_default' => 'session',

    /*
     * ---------------------------------------------------------------
     * 默认 API 驱动
     * ---------------------------------------------------------------
     *
     * API 认证驱动连接
     */
    'api_default' => 'token',

    /*
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

            // 模型实体
            'entity' => common\domain\entity\user::class,

            // 用户信息持久化名字
            'user_persistence' => 'user_persistence',

            // Token 持久化名字
            'token_persistence' => 'token_persistence',

            // 查询字段
            'field' => 'id,name,nikename,email,mobile',
        ],

        'token' => [
            // driver
            'driver' => 'token',

            // 模型实体
            'entity' => common\domain\entity\user::class,

            // 用户信息持久化名字
            'user_persistence' => 'user_persistence',

            // Token 持久化名字
            'token_persistence' => 'token_persistence',

            // 查询字段
            'field' => 'id,name,nikename,email,mobile',
        ],
    ],
];
