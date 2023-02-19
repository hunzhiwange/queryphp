<?php

declare(strict_types=1);

namespace Tests\Example;

use Tests\TestCase;

final class ExampleTest extends TestCase
{
    public function testBaseUse(): void
    {
        static::assertSame('QueryPHP', 'QueryPHP');
    }
}
