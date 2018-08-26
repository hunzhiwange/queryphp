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
      * 通用模板注释和变量解析
      * ---------------------------------------------------------------
      *
      * 模板中支持 {{var}} 变量替换
      */
    'template' => [
        'file_comment' => '/**
 * {{file_name}}
 *
 * @author {{file_author}}
 *
 * @since {{file_since}}
 *
 * @version {{file_version}}
 */',
        'file_name'    => '',
        'file_since'   => date('Y.m.d'),
        'file_version' => '1.0',
        'file_author'  => 'Name Your <your@mail.com>',
    ],
];
