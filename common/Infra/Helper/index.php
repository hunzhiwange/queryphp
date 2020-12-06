<?php

declare(strict_types=1);

namespace Common\Infra\Helper;

/**
 * 目录索引函数.
 *
 * - 使用方法 func(fn() => \Common\Infra\Helper\foo_bar())
 */
function foo_bar(string $extend = ''): string
{
    return 'call foo bar'.$extend;
}

class index
{
}
