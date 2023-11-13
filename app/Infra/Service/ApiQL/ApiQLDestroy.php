<?php

declare(strict_types=1);

namespace App\Infra\Service\ApiQL;

use App\Infra\Service\Support\Destroy as CommonDestroy;
use App\Infra\Service\Support\DestroyParams;

/**
 * API查询语言删除.
 */
class ApiQLDestroy
{
    use CommonDestroy {
        CommonDestroy::handle as handleCommonDestroy;
    }
    use ParseEntityClass;

    public function handle(DestroyParams $params): array
    {
        $this->setEntityClass($params);

        return $this->handleCommonDestroy($params);
    }

    protected function setEntityClass(DestroyParams $params): void
    {
        $params->entityClass = $this->parseEntityClass($params->entityClass);
    }
}
