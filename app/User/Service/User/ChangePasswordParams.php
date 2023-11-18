<?php

declare(strict_types=1);

namespace App\User\Service\User;

use App\Infra\Dto\ParamsDto;
use App\Infra\Validate\User\User as UserValidate;

/**
 * 用户修改密码参数.
 */
class ChangePasswordParams extends ParamsDto
{
    public int $id = 0;

    public string $oldPwd = '';

    public string $newPwd = '';

    public string $confirmPwd = '';

    public string $validatorClass = UserValidate::class;

    public string $validatorScene = 'change_password';
}
