<?php

declare(strict_types=1);

namespace App\Domain\Service\User\User;

use App\Domain\Validate\User\User as UserValidate;
use App\Domain\Validate\ValidateParams;
use Leevel\Support\Dto;

/**
 * 用户修改密码参数.
 */
class ChangePasswordParams extends Dto
{
    use ValidateParams;

    public int $id;

    public string $oldPwd;

    public string $newPwd;

    public string $confirmPwd;

    /**
     * 校验基本参数.
     */
    public function validate(): void
    {
        $this->baseValidate(
            new UserValidate(),
            'change_password',
        );
    }
}
