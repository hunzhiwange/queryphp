<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Permission;

use App\Domain\Dto\ParamsDto;
use App\Domain\Entity\User\Permission;
use App\Domain\Validate\User\Permission as PermissionValidate;
use Leevel\Validate\UniqueRule;

/**
 * 权限更新参数.
 */
class UpdateParams extends ParamsDto
{
    use BaseStoreUpdateParams;

    public int $id;

    protected string $validatorClass = PermissionValidate::class;

    protected string $validatorScene = 'update';

    /**
     * {@inheritDoc}
     */
    protected function validatorClassArgs(): array
    {
        $uniqueRule = UniqueRule::rule(
            Permission::class,
            exceptId: $this->id,
        );

        return [$uniqueRule];
    }
}
