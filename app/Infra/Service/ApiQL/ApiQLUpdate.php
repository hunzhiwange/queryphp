<?php

declare(strict_types=1);

namespace App\Infra\Service\ApiQL;

use App\Infra\Service\Support\Update as CommonUpdate;
use App\Infra\Service\Support\UpdateParams;
use Leevel\Database\Ddd\Entity;
use Leevel\Support\Arr\Except;

/**
 * API查询语言更新.
 */
class ApiQLUpdate
{
    use CommonUpdate {
        CommonUpdate::handle as handleCommon;
    }

    use ParseEntityClass;

    public function handle(UpdateParams $params): Entity
    {
        $this->setEntityClass($params);

        return $this->handleCommon($params);
    }

    protected function setEntityClass(UpdateParams $params): void
    {
        $params->entityClass = $this->parseEntityClass($params->entityClass);
    }

    /**
     * 组装实体数据.
     */
    /** @phpstan-ignore-next-line */
    private function data(UpdateParams $params): array
    {
        $primaryId = $params->entityClass::ID;

        return Except::handle($params->entityData, [$primaryId]);
    }
}
