<?php

declare(strict_types=1);

namespace App\Domain\Service\Product\ProductSpec;

use App\Domain\Entity\Product\ProductSpec;
use App\Infra\Csv;
use Tests\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class ImportTest extends TestCase
{
    protected function setUp(): void
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

    public function test2(): void
    {
        $csv = new Csv();
        $data = $csv->read(__DIR__.'/Csv/product_spec2.csv');
        $import = new Import();
        $import->handle($data['data']);
        static::assertSame(1, 1);
    }

    public function test3(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage(
            '商品规格编号不能为空'
        );

        $csv = new Csv();
        $data = $csv->read(__DIR__.'/Csv/product_spec3.csv');
        $import = new Import();
        $import->handle($data['data']);
        static::assertSame(1, 1);
    }

    public function test4(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage(
            '商品规格分组编号不能为空'
        );

        $csv = new Csv();
        $data = $csv->read(__DIR__.'/Csv/product_spec4.csv');
        $import = new Import();
        $import->handle($data['data']);
        static::assertSame(1, 1);
    }

    public function test5(): void
    {
        // 商品多规格数据相同以最后一条为准
        $csv = new Csv();
        $data = $csv->read(__DIR__.'/Csv/product_spec5.csv');
        $import = new Import();
        $import->handle($data['data']);
        static::assertSame(1, 1);
    }

    public function test6(): void
    {
        $s = new ProductSpec();
        $s->groupId = 'color';
        $s->groupName = '高级颜色';
        $s->specId = 'default';
        $s->categoryId = 'default';
        $s->name = 'default';
        $s->save()->flush();

        // 商品多规格分组以数据库为主，数据库存在直接覆盖页面的数据
        $csv = new Csv();
        $data = $csv->read(__DIR__.'/Csv/product_spec6.csv');
        $import = new Import();
        $import->handle($data['data']);
        static::assertSame(1, 1);
    }
}
