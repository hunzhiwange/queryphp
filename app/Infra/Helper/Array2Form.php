<?php

declare(strict_types=1);

namespace App\Infra\Helper;

/**
 * PHP 数组转 form 格式化.
 *
 * - 主要用于 postman 粘贴单元测试中的输入数据为 postman form-data 格式
 */
class Array2Form
{
    public static function handle(array $data): string
    {
        $query = explode('&', http_build_query($data));

        array_walk(
            $query,
            function (&$v) {
                $v = urldecode(str_replace('=', ':', $v));
            },
        );

        return PHP_EOL . implode(PHP_EOL, $query);
    }
}
