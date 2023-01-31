<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Permission;

use App\Domain\Entity\User\Permission;
use App\Domain\Service\Support\Show as CommonShow;
use Leevel\Database\Ddd\Entity;

/**
 * 权限查询.
 */
class Show
{
    use CommonShow;

    protected string $entityClass = Permission::class;

    private function prepareData(Entity $entity, array &$result): void
    {
        $result['resource'] = $entity->resource->toArray();
    }
}
