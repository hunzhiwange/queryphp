<?php

declare(strict_types=1);

namespace App\Domain\Service\Login;

use Leevel\Support\Dto;

class LoginParams extends Dto
{
    public string $appKey;

    public string $name;

    public string $password;

    public string $code;

    public int $remember = 0;
}
