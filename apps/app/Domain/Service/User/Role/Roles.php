<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Role;

use App\Domain\Entity\User\Role;
use App\Domain\Service\Support\Read;


/**
 * 角色列表.
 */
class Roles 
{
    use Read;
 
    public function handle(RolesParams $params): array
    {
        return $this->findLists($params, Role::class);
    }
}
