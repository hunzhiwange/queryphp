<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Role;

use Closure;
use App\Domain\Entity\User\Role;
use App\Domain\Service\Support\Read;
use Leevel\Database\Ddd\Select;
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
        $repository = $this->w->repository(Role::class);

        return $this->findPage($params, $repository);
    }

    private function prepareItem(Role $user): array
    {
        return $user->toArray();
    }

    /**
     * 查询条件.
     */
    private function condition(RolesParams $params): Closure
    {
        return function (Select $select) use ($params) {
            $this->spec($select, $params);
        };
    }
}
