<?php

declare(strict_types=1);

namespace App\Domain\Service\User\User;

use App\Domain\Dto\ParamsDto;
use App\Domain\Validate\User\User as UserValidate;

/**
 * 用户修改密码参数.
 */
class ChangePasswordParams extends ParamsDto
{
    public int $id;

    public string $oldPwd;

    public string $newPwd;

    public string $confirmPwd;

    protected string $validatorClass = UserValidate::class;

    protected string $validatorScene = 'change_password';
}
