<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Role;

use App\Domain\Dto\ParamsDto;
use App\Domain\Entity\User\Role;
use App\Domain\Validate\User\Role as RoleValidate;
use Leevel\Validate\UniqueRule;

/**
 * 角色更新参数.
 */
class UpdateParams extends ParamsDto
{
    public int $id;

    protected string $validatorClass = RoleValidate::class;

    protected string $validatorScene = 'update';

    /**
     * {@inheritDoc}
     */
    protected function validatorClassArgs(): array
    {
        $uniqueRule = UniqueRule::rule(
            Role::class,
            exceptId: $this->id,
        );

        return [$uniqueRule];
    }
}