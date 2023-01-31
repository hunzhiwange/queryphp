<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Role;

use App\Domain\Entity\User\Role;
use App\Domain\Validate\User\Role as RoleValidate;
use App\Domain\Service\Support\UpdateParams as CommonUpdateParams;

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