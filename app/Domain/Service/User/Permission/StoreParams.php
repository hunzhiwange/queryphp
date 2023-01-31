<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Permission;

use App\Domain\Entity\User\Permission;
use App\Domain\Validate\User\Permission as PermissionValidate;
use App\Domain\Service\Support\StoreParams as CommonStoreParams;

/**
 * 权限保存参数.
 */
class StoreParams extends CommonStoreParams
{
    use BaseStoreUpdateParams;

    protected string $validatorClass = PermissionValidate::class;

    protected string $entityClass = Permission::class;
}
