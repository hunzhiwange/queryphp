<?php

declare(strict_types=1);

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
 *
 * @internal
 *
 * @coversNothing
 */
final class PHPUnitTest extends TestCase
{
    public function testBaseUse(): void
    {
        static::assertSame('QueryPHP', 'QueryPHP');
    }
}
