<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Permission;

use App\Domain\Entity\User\Permission;
use App\Domain\Validate\User\Permission as PermissionValidate;
use Leevel\Support\Dto;
use Leevel\Validate\UniqueRule;

/**
 * 权限保存参数.
 */
class StoreParams extends Dto
{
    use BaseStoreUpdateParams;

    protected string $validatorClass = PermissionValidate::class;

    protected string $validatorScene = 'store';

    /**
     * {@inheritDoc}
     */
    protected function validatorClassArgs(): array
    {
        $uniqueRule = UniqueRule::rule(
            Permission::class,
        );

        return [$uniqueRule];
    }
}
