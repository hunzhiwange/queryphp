<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Role;

use App\Domain\Service\Support\Show as CommonShow;
use App\Domain\Entity\User\Role;
use Leevel\Database\Ddd\Entity;

/**
 * 角色查询.
 */
class Show
{
    use CommonShow;

    protected string $entityClass = Role::class;

    private function prepareData(Entity $entity, array &$result): void
    {
        $result['permission'] = $entity->permission->toArray();
    }
}
