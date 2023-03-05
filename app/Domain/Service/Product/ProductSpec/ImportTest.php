<?php

declare(strict_types=1);

namespace App\Domain\Service\Product\ProductSpec;

use App\Domain\Entity\Product\ProductSpec;
use App\Domain\Entity\Product\ProductSpecGroup;
use App\Infra\Csv;
use Tests\TestCase;

/**
 * @internal
 */
final class ImportTest extends TestCase
{
    protected function setUp(): void
    {
        $this->truncateDatabase(['product_spec', 'product_spec_group']);
    }

    public function test1(): void
    {
        $csv = new Csv();
        $data = $csv->read(__DIR__.'/Csv/product_spec.csv');
        $import = new Import();
        $import->handle($data['data']);
        $specField = [
            'group_id',
            'name',
            'spec_id',
            'searching',
        ];
        $result = ProductSpec::findMany(null, $specField)->toArray();
        $data = <<<'eot'
[
    {
        "group_id": "color",
        "name": "红色",
        "spec_id": "red",
        "searching": 1,
        "searching_enum": "是"
    },
    {
        "group_id": "color",
        "name": "黑色",
        "spec_id": "black",
        "searching": 1,
        "searching_enum": "是"
    },
    {
        "group_id": "color",
        "name": "白色",
        "spec_id": "white",
        "searching": 0,
        "searching_enum": "否"
    },
    {
        "group_id": "size",
        "name": "L",
        "spec_id": "l",
        "searching": 1,
        "searching_enum": "是"
    },
    {
        "group_id": "size",
        "name": "M",
        "spec_id": "m",
        "searching": 0,
        "searching_enum": "否"
    },
    {
        "group_id": "size",
        "name": "XL",
        "spec_id": "xl",
        "searching": 1,
        "searching_enum": "是"
    },
    {
        "group_id": "size",
        "name": "XL\/XL",
        "spec_id": "K2",
        "searching": 0,
        "searching_enum": "否"
    },
    {
        "group_id": "cup",
        "name": "A",
        "spec_id": "10",
        "searching": 0,
        "searching_enum": "否"
    },
    {
        "group_id": "cup",
        "name": "B",
        "spec_id": "11",
        "searching": 1,
        "searching_enum": "是"
    },
    {
        "group_id": "cup",
        "name": "C",
        "spec_id": "12",
        "searching": 1,
        "searching_enum": "是"
    },
    {
        "group_id": "cup",
        "name": "D",
        "spec_id": "13",
        "searching": 0,
        "searching_enum": "否"
    },
    {
        "group_id": "cup",
        "name": "E",
        "spec_id": "14",
        "searching": 0,
        "searching_enum": "否"
    },
    {
        "group_id": "xilie",
        "name": "时尚蕾丝",
        "spec_id": "J1",
        "searching": 0,
        "searching_enum": "否"
    },
    {
        "group_id": "xilie",
        "name": "锦棉系列",
        "spec_id": "J2",
        "searching": 0,
        "searching_enum": "否"
    },
    {
        "group_id": "xilie",
        "name": "轻盈无痕",
        "spec_id": "J3",
        "searching": 0,
        "searching_enum": "否"
    },
    {
        "group_id": "xilie",
        "name": "聚拢杯",
        "spec_id": "J4",
        "searching": 0,
        "searching_enum": "否"
    },
    {
        "group_id": "xilie",
        "name": "纤体美塑",
        "spec_id": "J5",
        "searching": 0,
        "searching_enum": "否"
    },
    {
        "group_id": "mianliao",
        "name": "厚",
        "spec_id": "ML1",
        "searching": 1,
        "searching_enum": "是"
    },
    {
        "group_id": "mianliao",
        "name": "超薄",
        "spec_id": "ML2",
        "searching": 1,
        "searching_enum": "是"
    },
    {
        "group_id": "mianliao",
        "name": "加厚\/薄",
        "spec_id": "ML3",
        "searching": 1,
        "searching_enum": "是"
    },
    {
        "group_id": "mianliao",
        "name": "厚度",
        "spec_id": "ML4",
        "searching": 1,
        "searching_enum": "是"
    },
    {
        "group_id": "price",
        "name": "亲民",
        "spec_id": "DW1",
        "searching": 1,
        "searching_enum": "是"
    },
    {
        "group_id": "price",
        "name": "高端",
        "spec_id": "DW2",
        "searching": 1,
        "searching_enum": "是"
    },
    {
        "group_id": "price",
        "name": "奢侈",
        "spec_id": "DW3",
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

    public function test2(): void
    {
        $csv = new Csv();
        $data = $csv->read(__DIR__.'/Csv/product_spec2.csv');
        $import = new Import();
        $import->handle($data['data']);
        $specField = [
            'group_id',
            'name',
            'spec_id',
            'searching',
        ];
        $result = ProductSpec::findMany(null, $specField)->toArray();
        $data = <<<'eot'
[
    {
        "group_id": "color",
        "name": "红色",
        "spec_id": "red",
        "searching": 1,
        "searching_enum": "是"
    },
    {
        "group_id": "color",
        "name": "黑色",
        "spec_id": "black",
        "searching": 1,
        "searching_enum": "是"
    },
    {
        "group_id": "color",
        "name": "白色",
        "spec_id": "white",
        "searching": 0,
        "searching_enum": "否"
    },
    {
        "group_id": "size",
        "name": "L",
        "spec_id": "l",
        "searching": 1,
        "searching_enum": "是"
    },
    {
        "group_id": "size",
        "name": "M",
        "spec_id": "m",
        "searching": 0,
        "searching_enum": "否"
    },
    {
        "group_id": "size",
        "name": "XL",
        "spec_id": "xl",
        "searching": 1,
        "searching_enum": "是"
    },
    {
        "group_id": "size",
        "name": "XL\/XL",
        "spec_id": "K2",
        "searching": 0,
        "searching_enum": "否"
    },
    {
        "group_id": "cup",
        "name": "A",
        "spec_id": "10",
        "searching": 0,
        "searching_enum": "否"
    },
    {
        "group_id": "cup",
        "name": "B",
        "spec_id": "11",
        "searching": 1,
        "searching_enum": "是"
    },
    {
        "group_id": "cup",
        "name": "C",
        "spec_id": "12",
        "searching": 1,
        "searching_enum": "是"
    },
    {
        "group_id": "cup",
        "name": "D",
        "spec_id": "13",
        "searching": 0,
        "searching_enum": "否"
    },
    {
        "group_id": "cup",
        "name": "E",
        "spec_id": "14",
        "searching": 0,
        "searching_enum": "否"
    },
    {
        "group_id": "xilie",
        "name": "时尚蕾丝",
        "spec_id": "J1",
        "searching": 0,
        "searching_enum": "否"
    },
    {
        "group_id": "xilie",
        "name": "锦棉系列",
        "spec_id": "J2",
        "searching": 0,
        "searching_enum": "否"
    },
    {
        "group_id": "xilie",
        "name": "轻盈无痕",
        "spec_id": "J3",
        "searching": 0,
        "searching_enum": "否"
    },
    {
        "group_id": "xilie",
        "name": "聚拢杯",
        "spec_id": "J4",
        "searching": 0,
        "searching_enum": "否"
    },
    {
        "group_id": "xilie",
        "name": "纤体美塑",
        "spec_id": "J5",
        "searching": 0,
        "searching_enum": "否"
    },
    {
        "group_id": "mianliao",
        "name": "厚",
        "spec_id": "ML1",
        "searching": 1,
        "searching_enum": "是"
    },
    {
        "group_id": "mianliao",
        "name": "超薄",
        "spec_id": "ML2",
        "searching": 1,
        "searching_enum": "是"
    },
    {
        "group_id": "mianliao",
        "name": "加厚\/薄",
        "spec_id": "ML3",
        "searching": 1,
        "searching_enum": "是"
    },
    {
        "group_id": "price",
        "name": "厚度",
        "spec_id": "ML4",
        "searching": 1,
        "searching_enum": "是"
    },
    {
        "group_id": "price",
        "name": "亲民",
        "spec_id": "DW1",
        "searching": 1,
        "searching_enum": "是"
    },
    {
        "group_id": "price",
        "name": "高端",
        "spec_id": "DW2",
        "searching": 1,
        "searching_enum": "是"
    },
    {
        "group_id": "price",
        "name": "奢侈",
        "spec_id": "DW3",
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
        $this->expectException(\App\Exceptions\TimeBusinessException::class);
        $this->expectExceptionMessage(
            '{"spec_id":["商品规格编号 不能为空","商品规格编号 只能是字母、数字、短横线和下划线"]}'
        );

        $csv = new Csv();
        $data = $csv->read(__DIR__.'/Csv/product_spec3.csv');
        $import = new Import();
        $import->handle($data['data']);
    }

    public function test4(): void
    {
        $this->expectException(\App\Exceptions\TimeBusinessException::class);
        $this->expectExceptionMessage(
            '{"group_id":["商品规格分组编号 不能为空"]}'
        );

        $csv = new Csv();
        $data = $csv->read(__DIR__.'/Csv/product_spec4.csv');
        $import = new Import();
        $import->handle($data['data']);
    }

    public function test5(): void
    {
        // 商品多规格数据相同以最后一条为准
        $csv = new Csv();
        $data = $csv->read(__DIR__.'/Csv/product_spec5.csv');
        $import = new Import();
        $import->handle($data['data']);
        $specField = [
            'group_id',
            'name',
            'spec_id',
            'searching',
        ];
        $result = ProductSpec::findMany(null, $specField)->toArray();
        $data = <<<'eot'
[
    {
        "group_id": "color",
        "name": "白色",
        "spec_id": "red",
        "searching": 0,
        "searching_enum": "否"
    },
    {
        "group_id": "color",
        "name": "黑色",
        "spec_id": "black",
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

    public function test6(): void
    {
        $s = new ProductSpecGroup();
        $s->groupId = 'color';
        $s->groupName = '高级颜色';
        $s->categoryId = 'default';
        $s->save()->flush();

        // 商品多规格分组以数据库为主，数据库存在不会做任何操作
        $csv = new Csv();
        $data = $csv->read(__DIR__.'/Csv/product_spec6.csv');
        $import = new Import();
        $import->handle($data['data']);
        $specField = [
            'group_id',
            'name',
            'spec_id',
            'searching',
        ];
        $result = ProductSpec::findMany(null, $specField)->toArray();
        $data = <<<'eot'
[
    {
        "group_id": "color",
        "name": "白色",
        "spec_id": "red",
        "searching": 0,
        "searching_enum": "否"
    },
    {
        "group_id": "color",
        "name": "黑色",
        "spec_id": "black",
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
    }

    public function test7(): void
    {
        $this->expectException(\App\Exceptions\TimeBusinessException::class);
        $this->expectExceptionMessage(
            '{"searching":["是否用于搜索过滤 0=否;1=是; 必须在 0,1 范围内"]}'
        );

        $csv = new Csv();
        $data = $csv->read(__DIR__.'/Csv/product_spec7.csv');
        $import = new Import();
        $import->handle($data['data']);
    }

    public function test8(): void
    {
        $this->expectException(\App\Exceptions\TimeBusinessException::class);
        $this->expectExceptionMessage(
            '{"searching":["是否用于搜索过滤 0=否;1=是; 必须在 0,1 范围内"]}'
        );

        $csv = new Csv();
        $data = $csv->read(__DIR__.'/Csv/product_spec8.csv');
        $import = new Import();
        $import->handle($data['data']);
    }

    public function test9(): void
    {
        $this->expectException(\App\Exceptions\TimeBusinessException::class);
        $this->expectExceptionMessage(
            '{"searching":["是否用于搜索过滤 0=否;1=是; 必须在 0,1 范围内"]}'
        );

        $csv = new Csv();
        $data = $csv->read(__DIR__.'/Csv/product_spec9.csv');
        $import = new Import();
        $import->handle($data['data']);
    }
}
