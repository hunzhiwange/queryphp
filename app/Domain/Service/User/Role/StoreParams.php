<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Role;

use App\Domain\Entity\User\Role;
use App\Domain\Service\Support\StoreParams as CommonStoreParams;
use App\Domain\Validate\User\Role as RoleValidate;

/**
 * 角色保存参数.
 */
class StoreParams extends CommonStoreParams
{
    use BaseStoreUpdateParams;

    protected string $validatorClass = RoleValidate::class;

    protected string $entityClass = Role::class;
}
