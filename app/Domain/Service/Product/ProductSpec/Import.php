<?php

declare(strict_types=1);

namespace App\Domain\Service\Product\ProductSpec;

use App\Domain\Entity\Product\ProductSpec;
use App\Domain\Entity\Product\ProductSpecGroup;
use Leevel\Database\Ddd\UnitOfWork;
use Leevel\Support\Arr\Only;

/**
 * 项目多规格导入.
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
            ProductSpec::select()->insertAll($data[0], [], static::SPEC_FIELD);

            if ($data[1]) {
                ProductSpecGroup::select()->insertAll($data[1]);
            }
        });
        $w->flush();
    }

    protected function prepareData(array $data): array
    {
        $this->validateSpecItem($data);

        $groupIds = array_column($data, 'group_id');
        $oldGroupData = $this->getGroupData($groupIds);
        $group = [];
        foreach ($data as $item) {
            if (isset($oldGroupData[$item['group_id']])) {
                continue;
            }
            foreach (static::SPEC_GROUP_FIELD as $field) {
                if ('' !== $item[$field]) {
                    // 规格分组数据以最后一个为准
                    $group[$item['group_id']][$field] = $item[$field];
                }
            }
        }

        $specItem = $this->prepareSpecItem($data, $item);

        return [$specItem, $group];
    }

    protected function getGroupData(array $groupIds): array
    {
        if (!$groupIds) {
            return [];
        }

        $groupData = ProductSpecGroup::select()
            ->whereIn('group_id', $groupIds)
            ->where('group_main', 1)
            ->setColumns(static::SPEC_GROUP_FIELD)
            ->findArray()
        ;

        return array_column($groupData, null, 'group_id');
    }

    protected function prepareSpecItem(array $data): array
    {
        foreach ($data as &$item) {
            $item = Only::handle($item, static::SPEC_FIELD);
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
        }
    }
}
