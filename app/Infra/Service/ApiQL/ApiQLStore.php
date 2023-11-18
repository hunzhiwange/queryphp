<?php

declare(strict_types=1);

namespace App\Infra\Service\ApiQL;

use App\Infra\Service\Support\Store as CommonStore;
use App\Infra\Service\Support\StoreParams;
use Leevel\Database\Ddd\Entity;

/**
 * API查询语言保存.
 */
class ApiQLStore
{
    use CommonStore {
        CommonStore::handle as handleCommon;
    }

    use ParseEntityClass;

    public function handle(StoreParams $params): Entity
    {
        $this->setEntityClass($params);

        return $this->handleCommon($params);
    }

    protected function setEntityClass(StoreParams $params): void
    {
        $params->entityClass = $this->parseEntityClass($params->entityClass);
    }

    /**
     * 组装实体数据.
     */
    /** @phpstan-ignore-next-line */
    private function data(StoreParams $params): array
    {
        return $params->entityData;
    }
}
