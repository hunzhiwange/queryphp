<?php

declare(strict_types=1);

namespace App\Domain\Service\Product\ProductBrand;

use App\Domain\Entity\Product\ProductBrand;
use App\Infra\Csv;
use Tests\TestCase;

/**
 * @internal
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

    public function test3(): void
    {
        $this->expectException(\ValueError::class);
        $this->expectExceptionMessage(
            '4 is not a valid backing value for enum'
        );

        $s = new ProductBrand();
        $s->brandId = 'mi';
        $s->name = '高级小米';
        $s->searching = 4;
    }

    public function test4(): void
    {
        $this->expectException(\App\Exceptions\TimeBusinessException::class);
        $this->expectExceptionMessage(
            '{"brand_id":["商品品牌编号 不能为空","商品品牌编号 只能是字母、数字、短横线和下划线"],"name":["商品品牌名字 不能为空"],"searching":["是否用于搜索过滤 0=否;1=是; 必须在 0,1 范围内"]}'
        );

        $csv = new Csv();
        $data = $csv->read(__DIR__.'/Csv/product_brand3.csv');
        $import = new Import();
        $import->handle($data['data']);
    }
}
