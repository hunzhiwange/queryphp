<?php

declare(strict_types=1);

namespace App\Domain\Service\Product\ProductBrand;

use App\Domain\Entity\Product\ProductBrand;
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
        $this->truncateDatabase(['product_brand']);
    }

    public function test1(): void
    {
        $csv = new Csv();
        $data = $csv->read(__DIR__.'/Csv/product_brand.csv');
        $import = new Import();
        $import->handle($data['data']);
        $specGroupField = [
            'brand_id',
            'name',
            'searching',
        ];
        $result = ProductBrand::findMany(null, $specGroupField)->toArray();
        $data = <<<'eot'
[
    {
        "brand_id": "jd",
        "name": "京东",
        "searching": 1,
        "searching_enum": "是"
    },
    {
        "brand_id": "baidu",
        "name": "百度",
        "searching": 1,
        "searching_enum": "是"
    },
    {
        "brand_id": "huawei",
        "name": "华为",
        "searching": 1,
        "searching_enum": "是"
    },
    {
        "brand_id": "mi",
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
        $s = new ProductBrand();
        $s->brandId = 'mi';
        $s->name = '高级小米';
        $s->searching = 1;
        $s->save()->flush();

        $specGroupField = [
            'brand_id',
            'name',
            'searching',
        ];
        $result = ProductBrand::findMany(null, $specGroupField)->toArray();
        $data = <<<'eot'
[
    {
        "brand_id": "mi",
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
        $data = $csv->read(__DIR__.'/Csv/product_brand2.csv');
        $import = new Import();
        $import->handle($data['data']);
        $result = ProductBrand::findMany(null, $specGroupField)->toArray();
        $data = <<<'eot'
[
    {
        "brand_id": "mi",
        "name": "小米",
        "searching": 0,
        "searching_enum": "否"
    },
    {
        "brand_id": "jd",
        "name": "京东",
        "searching": 1,
        "searching_enum": "是"
    },
    {
        "brand_id": "baidu",
        "name": "百度",
        "searching": 1,
        "searching_enum": "是"
    },
    {
        "brand_id": "huawei",
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
}
