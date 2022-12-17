<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Role;

use App\Domain\Entity\User\Role;
use App\Domain\Validate\User\Role as RoleValidate;
use App\Domain\Validate\ValidateParams;
use Leevel\Support\Dto;
use Leevel\Validate\UniqueRule;

/**
 * 角色更新参数.
 */
class UpdateParams extends Dto
{
    use BaseStoreUpdateParams;
    use ValidateParams;

    public int $id;

    /**
     * 校验基本参数.
     */
    public function validate(): void
    {
        $uniqueRule = UniqueRule::rule(
            Role::class,
            exceptId:$this->id,
        );

        $this->baseValidate(
            new RoleValidate($uniqueRule),
            'update',
        );
    }
}
