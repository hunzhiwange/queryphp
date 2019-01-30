<?php

declare(strict_types=1);

/*
 * This file is part of the your app package.
 *
 * The PHP Application For Code Poem For You.
 * (c) 2018-2099 http://yourdomian.com All rights reserved.
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
    'default' => 'api',

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
     * 虽然有不同的驱动，但是在验证使用上却有着一致性
     */
    'connect' => [
        'session' => [
            // driver
            'driver' => 'session',

            // token
            'token' => 'token',
        ],

        'token' => [
            // driver
            'driver' => 'token',

            // token
            'token' => null,

            // input token
            'input_token' => 'token',
        ],
    ],
];
