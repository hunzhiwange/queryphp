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
     * 默认视图驱动
     * ---------------------------------------------------------------
     *
     * 系统为所有视图提供了统一的接口，在使用上拥有一致性
     */
    'default' => Leevel::env('VIEW_DRIVER', 'html'),

    /*
     * ---------------------------------------------------------------
     * 错误模板
     * ---------------------------------------------------------------
     *
     * 默认错误跳转对应的模板文件
     */
    'action_fail' => 'public/fail',

    /*
     * ---------------------------------------------------------------
     * 成功模板
     * ---------------------------------------------------------------
     *
     * 默认成功跳转对应的模板文件
     */
    'action_success' => 'public/success',

    /*
     * ---------------------------------------------------------------
     * 视图连接参数
     * ---------------------------------------------------------------
     *
     * 这里为所有的视图的连接参数，每一种不同的驱动拥有不同的配置
     * 虽然有不同的驱动，但是在视图使用上却有着一致性
     */
    'connect' => [
        'html' => [
            // driver
            'driver' => 'html',

            // 后缀
            'suffix' => '.html',
        ],

        'twig' => [
            // driver
            'driver' => 'twig',

            // 后缀
            'suffix' => '.twig',
        ],

        'v8js' => [
            // driver
            'driver' => 'v8js',

            // 后缀
            'suffix' => '.js',

            // vue path
            'vue_path' => Leevel::path('node_modules/vue/dist/vue.js'),

            // vue renderer
            'vue_renderer' => Leevel::path('node_modules/vue-server-renderer/basic.js'),

            // art path
            'art_path' => Leevel::path('node_modules/art-template/lib/template-web.js'),
        ],

        'phpui' => [
            // driver
            'driver' => 'phpui',

            // 后缀
            'suffix' => '.php',
        ],
    ],
];
