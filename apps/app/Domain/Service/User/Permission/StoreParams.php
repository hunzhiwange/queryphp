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

    /**
     * 校验基本参数.
     */
    public function validate(): void
    {
        $uniqueRule = UniqueRule::rule(
            Permission::class,
        );

        $this->baseValidate(
            new PermissionValidate($uniqueRule),
            'store',
        );
    }
}
