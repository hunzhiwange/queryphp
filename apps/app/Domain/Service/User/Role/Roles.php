<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Role;

use App\Domain\Entity\User\Role;
use App\Domain\Service\Support\Read;
use Leevel\Database\Ddd\UnitOfWork;

/**
 * 角色列表.
 */
class Roles 
{
    use Read;

    public function __construct(private UnitOfWork $w)
    {
    }

    public function handle(RolesParams $params): array
    {
        return $this->findLists($params, Role::class);
    }
}
