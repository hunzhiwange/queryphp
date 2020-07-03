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
      * 通用模板注释和变量解析
      * ---------------------------------------------------------------
      *
      * 模板中支持 {{var}} 变量替换
      */
    'template' => [
        'header_comment' => <<<'EOT'
            /*
             * This file is part of the your app package.
             *
             * The PHP Application For Code Poem For You.
             * (c) 2018-2099 http://yourdomian.com All rights reserved.
             *
             * For the full copyright and license information, please view the LICENSE
             * file that was distributed with this source code.
             */
            EOT,
        'file_comment' => <<<'EOT'
            /**
             * {{file_title}}.
             */
            EOT,
        'file_name'    => '',
    ],

    /*
     * ---------------------------------------------------------------
     * 框架内部单元测试文档输出地址
     * ---------------------------------------------------------------
     *
     * 基于单元测试的文档自动生成
     */
    'framework_doc_outputdir' => Leevel::env('FRAMEWORK_DOC_OUTPUTDIR', ''),

    /*
     * ---------------------------------------------------------------
     * 框架内部单元测试文档 Git 仓库
     * ---------------------------------------------------------------
     *
     * 在文档中标注来源 Git 地址
     */
    'framework_doc_git' => Leevel::env('FRAMEWORK_DOC_GIT', ''),

    /*
     * ---------------------------------------------------------------
     * 框架内部单元测试文档日志输出地址
     * ---------------------------------------------------------------
     *
     * 文档生成日志
     */
    'framework_doc_logdir' => Leevel::env('FRAMEWORK_DOC_LOGDIR', ''),

    /*
     * ---------------------------------------------------------------
     * 框架内部单元测试文档支持的语言
     * ---------------------------------------------------------------
     *
     * 语言设置
     */
    'framework_doc_i18n' => Leevel::env('FRAMEWORK_DOC_I18N', ',zh-CN,zh-TW'),
];
