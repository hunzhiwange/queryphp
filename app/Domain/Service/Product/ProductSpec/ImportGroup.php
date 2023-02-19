<?php

declare(strict_types=1);

namespace App\Domain\Service\Product\ProductSpec;

use App\Domain\Entity\Product\ProductSpecGroup;
use App\Domain\Entity\Product\ProductSpecGroupGroupTypeEnum;
use App\Domain\Entity\Product\ProductSpecGroupSearchingEnum;
use Leevel\Database\Ddd\UnitOfWork;
use Leevel\Support\Arr\Only;

/**
 * 商品多规格分组导入.
 */
class ImportGroup
{
    private const SPEC_GROUP_FIELD = [
        'category_id',
        'group_id',
        'group_name',
        'group_sku_field',
        'group_type',
        'group_searching',
    ];

    public function handle(array $data): void
    {
        $data = $this->prepareData($data);
        $w = UnitOfWork::make();
        $w->persist(function () use ($data): void {
            ProductSpecGroup::select()->insertAll($data, [], self::SPEC_GROUP_FIELD);
        });
        $w->flush();
    }

    protected function prepareData(array $data): array
    {
        $this->validateSpecItem($data);
        $groupData = $this->prepareSpecGroupData($data);
        if (!$groupData) {
            throw new \Exception('导入的规格分组数据不能为空');
        }

        return $groupData;
    }

    protected function prepareSpecGroupData(array $data): array
    {
        foreach ($data as &$item) {
            $item = Only::handle($item, self::SPEC_GROUP_FIELD);
        }

        return $data;
    }

    /**
     * @throws \Exception
     */
    protected function validateSpecItem(array $data): void
    {
        foreach ($data as $item) {
            if (empty($item['group_id'])) {
                throw new \Exception('商品规格分组编号不能为空');
            }
            if (isset($item['group_type'])) {
                ProductSpecGroupGroupTypeEnum::from((int) $item['group_type']);
            }
            if (isset($item['group_searching'])) {
                ProductSpecGroupSearchingEnum::from((int) $item['group_searching']);
            }
            if (empty($item['group_name'])) {
                throw new \Exception('商品规格分组名字不能为空');
            }
        }
    }
}
