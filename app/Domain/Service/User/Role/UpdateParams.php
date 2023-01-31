<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Role;

use App\Domain\Entity\User\Role;
use App\Domain\Service\Support\UpdateParams as CommonUpdateParams;
use App\Domain\Validate\User\Role as RoleValidate;

/**
 * 角色更新参数.
 */
class UpdateParams extends CommonUpdateParams
{
    use BaseStoreUpdateParams;

    public int $id;

    protected string $validatorClass = RoleValidate::class;

    protected string $entityClass = Role::class;
}
