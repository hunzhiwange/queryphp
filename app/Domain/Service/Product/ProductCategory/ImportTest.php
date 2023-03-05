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

    public function test4(): void
    {
        $csv = new Csv();
        $data = $csv->read(__DIR__.'/Csv/product_category3.csv');
        $import = new Import();
        $import->handle($data['data']);
        $specGroupField = [
            'category_id',
            'parent_id',
            'name',
            'searching',
        ];
        $result = ProductCategory::findMany(null, $specGroupField)->toArray();
        $data = <<<'eot'
[
    {
        "category_id": "nk",
        "parent_id": "",
        "name": "男士内裤",
        "searching": 1,
        "searching_enum": "是"
    },
    {
        "category_id": "nkbn",
        "parent_id": "nk",
        "name": "男士保暖内裤",
        "searching": 1,
        "searching_enum": "是"
    },
    {
        "category_id": "sy",
        "parent_id": "",
        "name": "睡衣",
        "searching": 1,
        "searching_enum": "是"
    },
    {
        "category_id": "ks",
        "parent_id": "sy",
        "name": "宽松",
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

    public function test5(): void
    {
        $csv = new Csv();
        $data = $csv->read(__DIR__.'/Csv/product_category4.csv');
        $import = new Import();
        $import->handle($data['data']);
        $specGroupField = [
            'category_id',
            'parent_id',
            'name',
            'searching',
            'logo_large',
            'brand_id',
            'max_order_number',
            'sort',
        ];
        $result = ProductCategory::findMany(null, $specGroupField)->toArray();
        $data = <<<'eot'
[
    {
        "category_id": "nk",
        "parent_id": "",
        "name": "男士内裤",
        "searching": 1,
        "sort": 50000,
        "brand_id": "",
        "max_order_number": 0,
        "logo_large": "",
        "searching_enum": "是"
    },
    {
        "category_id": "nkbn",
        "parent_id": "nk",
        "name": "男士保暖内裤",
        "searching": 1,
        "sort": 50000,
        "brand_id": "nb1",
        "max_order_number": 0,
        "logo_large": "1.jpg",
        "searching_enum": "是"
    },
    {
        "category_id": "sy",
        "parent_id": "",
        "name": "睡衣",
        "searching": 1,
        "sort": 99,
        "brand_id": "",
        "max_order_number": 0,
        "logo_large": "",
        "searching_enum": "是"
    },
    {
        "category_id": "ks",
        "parent_id": "sy",
        "name": "宽松",
        "searching": 0,
        "sort": 666,
        "brand_id": "",
        "max_order_number": 33,
        "logo_large": "",
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

    public function test6(): void
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

    public function test7(): void
    {
        $this->expectException(\App\Exceptions\TimeBusinessException::class);
        $this->expectExceptionMessage(
            '{"category_id":["商品分类编号 不能为空","商品分类编号 只能是字母、数字、短横线和下划线"],"name":["商品分类名字 不能为空"],"searching":["是否用于搜索过滤 0=否;1=是; 必须在 0,1 范围内"]}'
        );

        $csv = new Csv();
        $data = $csv->read(__DIR__.'/Csv/product_category5.csv');
        $import = new Import();
        $import->handle($data['data']);
    }
}
