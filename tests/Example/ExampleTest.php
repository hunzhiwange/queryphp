<?php

declare(strict_types=1);

namespace Tests\Example;

use Tests\TestCase;

/**
 * 继承框架基础示例.
 *
 * @internal
 *
 * @coversNothing
 */
final class ExampleTest extends TestCase
{
    public function testBaseUse(): void
    {
        static::assertSame('QueryPHP', 'QueryPHP');
    }
}
