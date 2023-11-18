<?php

declare(strict_types=1);

namespace App\User\Service\User;

use App\Infra\Dto\ParamsDto;
use App\Infra\Validate\User\User as UserValidate;

/**
 * 解锁管理面板参数.
 */
class UnlockParams extends ParamsDto
{
    public int $id = 0;

    public string $token = '';

    public string $password = '';

    public string $validatorClass = UserValidate::class;

    public string $validatorScene = 'unlock';
}
