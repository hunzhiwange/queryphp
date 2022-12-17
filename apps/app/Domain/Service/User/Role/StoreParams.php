<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Role;

use App\Domain\Entity\User\Role;
use App\Domain\Validate\User\Role as RoleValidate;
use Leevel\Support\Dto;
use Leevel\Validate\UniqueRule;

/**
 * 角色保存参数.
 */
class StoreParams extends Dto
{
    use BaseStoreUpdateParams;

    protected string $validatorClass = RoleValidate::class;

    protected string $validatorScene = 'store';

    /**
     * {@inheritDoc}
     */
    protected function validatorClassArgs(): array
    {
        $uniqueRule = UniqueRule::rule(
            Role::class,
        );

        return [$uniqueRule];
    }
}
