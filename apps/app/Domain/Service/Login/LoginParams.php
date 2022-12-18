<?php

declare(strict_types=1);

namespace App\Domain\Service\Login;

use App\Domain\Dto\ParamsDto;
use App\Domain\Validate\User\User as UserValidate;

class LoginParams extends ParamsDto
{
    public string $appKey;

    public string $name;

    public string $password;

    public string $code;

    public int $remember = 0;

    protected string $validatorClass = UserValidate::class;

    protected string $validatorScene = 'login';
}
