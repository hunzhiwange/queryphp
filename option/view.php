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
     * 模板主题
     * ---------------------------------------------------------------
     *
     * 当前的模板主题文件，一般来说不用变更
     */
    'theme_name' => 'default',

    /*
     * ---------------------------------------------------------------
     * 默认主题扩展
     * ---------------------------------------------------------------
     *
     * 当前模板路径不存在的情况下默认路径的分析
     * see \Leevel\View\Html::parseDefaultFile
     */
    'theme_path_default' => '',

    /*
     * ---------------------------------------------------------------
     * 错误模板
     * ---------------------------------------------------------------
     *
     * 默认错误跳转对应的模板文件
     */
    'action_fail' => 'public+fail',

    /*
     * ---------------------------------------------------------------
     * 成功模板
     * ---------------------------------------------------------------
     *
     * 默认成功跳转对应的模板文件
     */
    'action_success' => 'public+success',

    /*
     * ---------------------------------------------------------------
     * 控制器和方法分割符
     * ---------------------------------------------------------------
     *
     * 系统默认使用 “/” 分隔，一般不用特别设置
     */
    'controlleraction_depr' => '/',

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

            // 模板缓存时间，模板编译缓存时间,单位秒,0 表示永不过期
            'cache_lifetime' => 2592000,
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
