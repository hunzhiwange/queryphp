<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Permission;

use App\Domain\Entity\User\Permission;
use App\Domain\Service\Support\Show as CommonShow;

/**
 * 权限查询.
 */
class Show
{
    use CommonShow;

    protected string $entityClass = Permission::class;

    public function handle(ShowParams $params): array
    {
        $entity = $this->find($params->id);
        $result = $entity->toArray();
        $result['resource'] = $entity->resource->toArray();

        return $result;
    }
}
