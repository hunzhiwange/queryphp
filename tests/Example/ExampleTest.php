<?php

declare(strict_types=1);

namespace Tests\Example;

use Tests\TestCase;

/**
 * @internal
 */
final class ExampleTest extends TestCase
{
    public function testBaseUse(): void
    {
        self::assertSame('QueryPHP', 'QueryPHP');
    }
}
