<?php

declare(strict_types=1);

namespace App\Domain\Service\Product\ProductSpec;

use App\Domain\Entity\Product\ProductSpecGroup;
use App\Infra\Csv;
use Tests\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class ImportGroupTest extends TestCase
{
    protected function setUp(): void
    {
        $this->truncateDatabase(['product_spec_group']);
    }

    public function test1(): void
    {
        $csv = new Csv();
        $data = $csv->read(__DIR__.'/Csv/product_spec_group.csv');
        $import = new ImportGroup();
        $import->handle($data['data']);
        $specGroupField = [
            'category_id',
            'group_id',
            'group_name',
            'group_sku_field',
            'group_type',
            'group_searching',
        ];
        $result = ProductSpecGroup::findMany(null, $specGroupField)->toArray();
        $data = <<<'eot'
[
    {
        "category_id": "fuzhuang",
        "group_id": "color",
        "group_name": "颜色",
        "group_sku_field": "spec1",
        "group_type": 0,
        "group_searching": 1,
        "group_type_enum": "SKU属性",
        "group_searching_enum": "是"
    },
    {
        "category_id": "fuzhuang",
        "group_id": "size",
        "group_name": "尺码",
        "group_sku_field": "spec2",
        "group_type": 0,
        "group_searching": 1,
        "group_type_enum": "SKU属性",
        "group_searching_enum": "是"
    },
    {
        "category_id": "neiyi",
        "group_id": "cup",
        "group_name": "罩杯",
        "group_sku_field": "spec3",
        "group_type": 0,
        "group_searching": 1,
        "group_type_enum": "SKU属性",
        "group_searching_enum": "是"
    },
    {
        "category_id": "fuzhuang",
        "group_id": "xilie",
        "group_name": "系列",
        "group_sku_field": "spec11",
        "group_type": 1,
        "group_searching": 0,
        "group_type_enum": "SPU属性",
        "group_searching_enum": "否"
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
        $s = new ProductSpecGroup();
        $s->groupId = 'color';
        $s->groupName = '高级颜色';
        $s->categoryId = 'default';
        $s->save()->flush();

        $specGroupField = [
            'category_id',
            'group_id',
            'group_name',
            'group_sku_field',
            'group_type',
            'group_searching',
        ];
        $result = ProductSpecGroup::findMany(null, $specGroupField)->toArray();
        $data = <<<'eot'
[
    {
        "category_id": "default",
        "group_id": "color",
        "group_name": "高级颜色",
        "group_sku_field": "",
        "group_type": 1,
        "group_searching": 0,
        "group_type_enum": "SPU属性",
        "group_searching_enum": "否"
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
        $data = $csv->read(__DIR__.'/Csv/product_spec_group2.csv');
        $import = new ImportGroup();
        $import->handle($data['data']);
        $result = ProductSpecGroup::findMany(null, $specGroupField)->toArray();
        $data = <<<'eot'
[
    {
        "category_id": "fuzhuang",
        "group_id": "color",
        "group_name": "颜色",
        "group_sku_field": "spec1",
        "group_type": 0,
        "group_searching": 1,
        "group_type_enum": "SKU属性",
        "group_searching_enum": "是"
    },
    {
        "category_id": "fuzhuang",
        "group_id": "size",
        "group_name": "尺码",
        "group_sku_field": "spec2",
        "group_type": 0,
        "group_searching": 1,
        "group_type_enum": "SKU属性",
        "group_searching_enum": "是"
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
