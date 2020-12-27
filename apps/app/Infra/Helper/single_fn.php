<?php

declare(strict_types=1);

namespace App\Infra\Helper;

/**
 * 单个函数.
 *
 * - 使用方法 func(fn() => \App\Infra\Helper\single_fn())
 */
function single_fn(): string
{
    return 'call single_fn';
}

class single_fn
{
}
