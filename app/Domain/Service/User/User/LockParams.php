<?php

declare(strict_types=1);

namespace App\Domain\Service\User\User;

use App\Domain\Dto\ParamsDto;
use App\Domain\Validate\User\User as UserValidate;

/**
 * 锁定管理面板参数.
 */
class LockParams extends ParamsDto
{
    public string $token;

    protected string $validatorClass = UserValidate::class;

    protected string $validatorScene = 'lock';
}
