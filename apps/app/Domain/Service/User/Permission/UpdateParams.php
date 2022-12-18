<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Permission;

use App\Domain\Entity\User\Permission;
use App\Domain\Validate\User\Permission as PermissionValidate;
use App\Domain\Service\Support\UpdateParams as CommonUpdateParams;

/**
 * 权限更新参数.
 */
class UpdateParams extends CommonUpdateParams
{
    use BaseStoreUpdateParams;

    public int $id;

    protected string $validatorClass = PermissionValidate::class;

    protected string $entityClass = Permission::class;
}
