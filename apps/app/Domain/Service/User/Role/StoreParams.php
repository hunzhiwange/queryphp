<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Role;

use App\Domain\Entity\User\Role;
use App\Domain\Validate\User\Role as RoleValidate;
use App\Domain\Service\Support\StoreParams as CommonStoreParams;

/**
 * 角色保存参数.
 */
class StoreParams extends CommonStoreParams
{
    use BaseStoreUpdateParams;

    protected string $validatorClass = RoleValidate::class;

    protected string $entityClass = Role::class;
}
