<?php

declare(strict_types=1);

namespace App\Company\Service;

use Leevel\Database\Ddd\Entity;
use Leevel\Database\Ddd\Select;

class InjectPlatformCompany
{
    /**
     * 注入平台和公司 ID.
     */
    public function handle(int $platformId, int $companyId): void
    {
        switch_database($platformId, $companyId);

        // 设置数据精度
        \App::instance('price_scale', 2);
        \App::instance('pay_price_scale', 2);
        \App::instance('quantity_scale', 2);
        \App::instance('without_decimal_zero', true);

        // 拥有 company_id,platform_id 字段的实体会做一些处理
        Entity::event(Entity::BOOT_EVENT, function (string $event, string $entityClass) use ($platformId, $companyId): void {
            // 自动添加全局查询过滤
            $condition = [];
            if ($entityClass::hasField('platform_id')) {
                $condition['platform_id'] = $platformId;
            }
            if ($entityClass::hasField('company_id')) {
                $condition['company_id'] = $companyId;
            }
            if ($condition) {
                $entityClass::addGlobalScope('company_id_platform_id', function (Select $select) use ($condition): void {
                    $select->where($condition);
                });
            }

            // 新增数据时自动添加
            $beforeCreateData = batch_inject_common_data($entityClass, [[]]);
            if ($beforeCreateData[0]) {
                $entityClass::event(Entity::BEFORE_CREATE_EVENT, function (string $event, Entity $entity) use ($beforeCreateData): void {
                    $entity->withProps($beforeCreateData[0]);
                });
            }

            // 更新数据时自动添加
            $beforeUpdateData = batch_inject_common_update_data($entityClass, [[]]);
            if ($beforeUpdateData[0]) {
                $entityClass::event(Entity::BEFORE_UPDATE_EVENT, function (string $event, Entity $entity) use ($beforeUpdateData): void {
                    $entity->withProps($beforeUpdateData[0]);
                });
            }
        });
    }
}
