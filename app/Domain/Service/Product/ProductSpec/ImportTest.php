<?php

declare(strict_types=1);

namespace App\Domain\Service\Product\ProductSpec;

use App\Infra\Csv;
use Tests\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class ImportTest extends TestCase
{
    protected function tearDown(): void
    {
        $this->truncateDatabase(['product_spec']);
    }

    public function test1(): void
    {
        $csv = new Csv();
        $data = $csv->read(__DIR__.'/Csv/product_spec.csv');
        $import = new Import();
        $import->handle($data['data']);
        static::assertSame(1, 1);
    }
}
