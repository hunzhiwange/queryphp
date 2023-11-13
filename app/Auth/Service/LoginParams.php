<?php

declare(strict_types=1);

namespace App\Auth\Service;

use App\Infra\Dto\ParamsDto;
use App\Infra\Validate\User\User as UserValidate;

class LoginParams extends ParamsDto
{
    public string $appKey = '';

    public string $name = '';

    public string $password = '';

    public string $code = '';

    public int $remember = 0;

    public string $validatorClass = UserValidate::class;

    public string $validatorScene = 'login';
}
