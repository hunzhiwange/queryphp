<?php

declare(strict_types=1);

namespace Common\Infra\Helper;

/**
 * 分组函数例子.
 *
 * - 使用方法 func(fn() => \Common\Infra\Helper\testgroup_fn1())
 */
function testgroup_fn1(): string
{
    return 'call testgroup_fn1';
}

/**
 * 分组函数例子.
 *
 * - 使用方法 func(fn() => \Common\Infra\Helper\testgroup_fn2())`
 */
function testgroup_fn2(): string
{
    return 'call testgroup_fn2';
}

class testgroup
{
}
