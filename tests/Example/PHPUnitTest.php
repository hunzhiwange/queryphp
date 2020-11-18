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

namespace PHPUnit\Framework;

// 兼容执行 `php leevel make:doc` 命令时
// 无法找到 PHPUnit\Framework\TestCase 的情况
if (!class_exists('PHPUnit\\Framework\\TestCase')) {
    class TestCase
    {
    }
}

namespace Tests\Example;

use PHPUnit\Framework\TestCase;

/**
 * 原生 PHPUnit 示例.
 */
class PHPUnitTest extends TestCase
{
    public function testBaseUse(): void
    {
        $this->assertSame('QueryPHP', 'QueryPHP');
    }
}
