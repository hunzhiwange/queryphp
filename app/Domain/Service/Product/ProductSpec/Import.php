<?php

declare(strict_types=1);

namespace App\Domain\Service\Product\ProductSpec;

use App\Domain\Entity\Product\ProductSpec;
use Leevel\Database\Ddd\UnitOfWork;

/**
 * 项目多规格导入.
 */
class Import
{
    public function handle(array $data): void
    {
        $data = $this->fillData($data);

        $w = UnitOfWork::make();
        $w->persist(function () use ($data): void {
            $lastInsertId = ProductSpec::select()->insertAll($data, [], [
                'category_id',
                'group_id',
                'group_name',
                'group_main',
                'group_sku_field',
                'group_type',
                'group_searching',
                'name',
                'spec_id',
                'searching',
            ]);
        });
        $w->flush();
    }

    protected function fillData(array $data): array
    {
        $groupField = ['category_id', 'group_id', 'group_name', 'group_sku_field', 'group_type', 'group_searching'];
        $groupIds = array_column($data, 'group_id');
        $groupData = [];
        if ($groupIds) {
            $groupData = ProductSpec::select()
                ->whereIn('group_id', $groupIds)
                ->where('group_main', 1)
                ->setColumns($groupField)
                ->asArray()
                ->select()
            ;

            /** @phpstan-ignore-next-line */
            $groupData = (array) $groupData->toArray();
            $groupData = array_column($groupData, null, 'group_id');
        }

        $group = [];
        foreach ($data as $item) {
            if (empty($item['group_id'])) {
                throw new \Exception('商品规格分组编号不能为空');
            }

            if (empty($item['spec_id'])) {
                throw new \Exception('商品规格编号不能为空');
            }

            if (!isset($groupData[$item['group_id']])) {
                foreach ($groupField as $field) {
                    if ('' !== $item[$field]) {
                        // 规格分组数据以最后一个为准
                        $group[$item['group_id']][$field] = $item[$field];
                    }
                }
            }
        }
        $group = array_merge($group, $groupData);

        $groupMain = [];
        foreach ($data as &$item) {
            $groupId = $item['group_id'];
            $item = array_merge($item, $group[$groupId]);

            if (!isset($groupData[$groupId])) {
                if (!isset($groupMain[$groupId])) {
                    $item['group_main'] = 1;
                    $groupMain[$groupId] = true;
                } else {
                    $item['group_main'] = 0;
                }
            }
        }
        unset($item);

        return $data;
    }
}
