<?php

declare(strict_types=1);

namespace Tests\Example;

use Tests\TestCase;

/**
 * 继承框架基础示例.
 */
class ExampleTest extends TestCase
{
    public function testBaseUse(): void
    {
        $this->assertSame('QueryPHP', 'QueryPHP');
    }
}
