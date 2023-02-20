<?php

declare(strict_types=1);

namespace App\Domain\Service\Product\ProductCategory;

use App\Domain\Entity\Product\ProductCategory;
use App\Infra\Csv;
use Tests\TestCase;

/**
 * @internal
 */
final class ImportTest extends TestCase
{
    protected function setUp(): void
    {
        $this->truncateDatabase(['product_category']);
    }

    public function test1(): void
    {
        $csv = new Csv();
        $data = $csv->read(__DIR__.'/Csv/product_category.csv');
        $import = new Import();
        $import->handle($data['data']);
        $specGroupField = [
            'category_id',
            'name',
            'searching',
        ];
        $result = ProductCategory::findMany(null, $specGroupField)->toArray();
        $data = <<<'eot'
[
    {
        "category_id": "jd",
        "name": "京东",
        "searching": 1,
        "searching_enum": "是"
    },
    {
        "category_id": "baidu",
        "name": "百度",
        "searching": 1,
        "searching_enum": "是"
    },
    {
        "category_id": "huawei",
        "name": "华为",
        "searching": 1,
        "searching_enum": "是"
    },
    {
        "category_id": "mi",
        "name": "小米",
        "searching": 0,
        "searching_enum": "否"
    }
]
eot;

        static::assertSame(
            $this->varJson(
                $result
            ),
            $data,
        );
    }

    public function test2(): void
    {
        $s = new ProductCategory();
        $s->categoryId = 'mi';
        $s->name = '高级小米';
        $s->searching = 1;
        $s->save()->flush();

        $specGroupField = [
            'category_id',
            'name',
            'searching',
        ];
        $result = ProductCategory::findMany(null, $specGroupField)->toArray();
        $data = <<<'eot'
[
    {
        "category_id": "mi",
        "name": "高级小米",
        "searching": 1,
        "searching_enum": "是"
    }
]
eot;

        static::assertSame(
            $this->varJson(
                $result
            ),
            $data,
        );

        $csv = new Csv();
        $data = $csv->read(__DIR__.'/Csv/product_category2.csv');
        $import = new Import();
        $import->handle($data['data']);
        $result = ProductCategory::findMany(null, $specGroupField)->toArray();
        $data = <<<'eot'
[
    {
        "category_id": "mi",
        "name": "小米",
        "searching": 0,
        "searching_enum": "否"
    },
    {
        "category_id": "jd",
        "name": "京东",
        "searching": 1,
        "searching_enum": "是"
    },
    {
        "category_id": "baidu",
        "name": "百度",
        "searching": 1,
        "searching_enum": "是"
    },
    {
        "category_id": "huawei",
        "name": "华为",
        "searching": 1,
        "searching_enum": "是"
    }
]
eot;

        static::assertSame(
            $this->varJson(
                $result
            ),
            $data,
        );
    }

    public function test3(): void
    {
        $this->expectException(\ValueError::class);
        $this->expectExceptionMessage(
            '4 is not a valid backing value for enum'
        );

        $s = new ProductCategory();
        $s->categoryId = 'mi';
        $s->name = '高级小米';
        $s->searching = 4;
    }
}
