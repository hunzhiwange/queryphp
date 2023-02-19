<?php

declare(strict_types=1);

namespace App\Domain\Service\Product\ProductSpec;

use App\Domain\Entity\Product\ProductSpec;
use App\Domain\Entity\Product\ProductSpecGroup;
use App\Domain\Entity\Product\ProductSpecGroupGroupTypeEnum;
use App\Domain\Entity\Product\ProductSpecGroupSearchingEnum;
use App\Domain\Entity\Product\ProductSpecSearchingEnum;
use Leevel\Database\Ddd\UnitOfWork;
use Leevel\Support\Arr\Only;

/**
 * 商品多规格导入.
 */
class Import
{
    private const SPEC_GROUP_FIELD = [
        'category_id',
        'group_id',
        'group_name',
        'group_sku_field',
        'group_type',
        'group_searching',
    ];

    private const  SPEC_FIELD = [
        'group_id',
        'name',
        'spec_id',
        'searching',
    ];

    public function handle(array $data): void
    {
        $data = $this->prepareData($data);
        $w = UnitOfWork::make();
        $w->persist(function () use ($data): void {
            ProductSpec::select()->insertAll($data['spec_data'], [], self::SPEC_FIELD);

            if ($data['group_data']) {
                ProductSpecGroup::select()->insertAll($data['group_data']);
            }
        });
        $w->flush();
    }

    protected function prepareData(array $data): array
    {
        $this->validateSpecItem($data);
        $groupData = $this->prepareGroupData($data);
        $specData = $this->prepareSpecData($data);

        return [
            'spec_data' => $specData,
            'group_data' => $groupData,
        ];
    }

    protected function queryGroupData(array $groupIds): array
    {
        if (!$groupIds) {
            return [];
        }

        $groupData = ProductSpecGroup::select()
            ->whereIn('group_id', $groupIds)
            ->setColumns(self::SPEC_GROUP_FIELD)
            ->findArray()
        ;

        return array_column($groupData, null, 'group_id');
    }

    protected function prepareSpecData(array $data): array
    {
        foreach ($data as &$item) {
            $item = Only::handle($item, self::SPEC_FIELD);
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

            if (empty($item['spec_id'])) {
                throw new \Exception('商品规格编号不能为空');
            }

            ProductSpecSearchingEnum::from((int) $item['searching']);
        }
    }

    protected function prepareGroupData(array $data): array
    {
        $groupIds = array_column($data, 'group_id');
        $oldGroupData = $this->queryGroupData($groupIds);
        $group = [];
        foreach ($data as $item) {
            if (isset($oldGroupData[$item['group_id']])) {
                continue;
            }
            foreach (self::SPEC_GROUP_FIELD as $field) {
                if ('' !== $item[$field]) {
                    // 规格分组数据以最后一个为准
                    $group[$item['group_id']][$field] = $item[$field];
                }
            }
        }

        foreach ($group as $v) {
            if (isset($v['group_type'])) {
                ProductSpecGroupGroupTypeEnum::from((int) $v['group_type']);
            }
            if (isset($v['group_searching'])) {
                ProductSpecGroupSearchingEnum::from((int) $v['group_searching']);
            }
        }

        return $group;
    }
}
