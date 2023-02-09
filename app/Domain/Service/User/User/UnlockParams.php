<?php

declare(strict_types=1);

namespace App\Domain\Service\User\User;

use App\Domain\Dto\ParamsDto;
use App\Domain\Validate\User\User as UserValidate;

/**
 * 解锁管理面板参数.
 */
class UnlockParams extends ParamsDto
{
    public int $id = 0;

    public string $token = '';

    public string $password = '';

    protected string $validatorClass = UserValidate::class;

    protected string $validatorScene = 'unlock';
}
