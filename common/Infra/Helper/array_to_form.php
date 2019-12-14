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

namespace Common\Infra\Helper;

/**
 * PHP 数组转 form 格式化.
 *
 * - 主要用于 postman 粘贴单元测试中的输入数据为 postman form-data 格式
 *
 * 使用方法.
 *
 * ```
 * echo f('Common\\Infra\\Helper\\array_to_form', ['foo' => 'bar']);
 * ```
 */
function array_to_form(array $data): string
{
    $query = explode('&', http_build_query($data));

    array_walk(
        $query,
        function (&$v) {
            $v = urldecode(str_replace('=', ':', $v));
        },
    );

    return PHP_EOL.implode(PHP_EOL, $query);
}

class array_to_form
{
}
