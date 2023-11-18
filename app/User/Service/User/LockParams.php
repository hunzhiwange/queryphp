<?php

declare(strict_types=1);

namespace App\User\Service\User;

use App\Infra\Dto\ParamsDto;
use App\Infra\Validate\User\User as UserValidate;

/**
 * 锁定管理面板参数.
 */
class LockParams extends ParamsDto
{
    public string $token = '';

    public string $validatorClass = UserValidate::class;

    public string $validatorScene = 'lock';
}
