<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Role;

use App\Domain\Entity\User\Role;
use App\Domain\Validate\User\Role as RoleValidate;
use App\Domain\Validate\Validate;
use App\Exceptions\UserBusinessException;
use App\Exceptions\UserErrorCode;
use Leevel\Support\Dto;
use Leevel\Validate\UniqueRule;

/**
 * 角色更新参数.
 */
class UpdateParams extends Dto
{
    use BaseStoreUpdateParams;

    public int $id;

    /**
     * 校验基本参数.
     *
     * @throws \App\Exceptions\UserBusinessException
     */
    public function validate(): void
    {
        $uniqueRule = UniqueRule::rule(
            Role::class,
            exceptId:$this->id,
        );

        $validator = Validate::make(new RoleValidate($uniqueRule), 'update', $this->toArray())->getValidator();
        if ($validator->fail()) {
            $e = json_encode($validator->error(), JSON_UNESCAPED_UNICODE);

            throw new UserBusinessException(UserErrorCode::ROLE_UPDATE_INVALID_ARGUMENT, $e, true);
        }
    }
}
