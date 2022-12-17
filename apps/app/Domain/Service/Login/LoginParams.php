<?php

declare(strict_types=1);

namespace App\Domain\Service\Login;

use App\Domain\Validate\User\User as UserValidate;
use App\Domain\Validate\ValidateParams;
use Leevel\Support\Dto;

class LoginParams extends Dto
{
    use ValidateParams;

    public string $appKey;

    public string $name;

    public string $password;

    public string $code;

    public int $remember = 0;

    /**
     * 校验基本参数.
     */
    public function validate(): void
    {
        $this->baseValidate(
            new UserValidate(),
            'login',
        );
    }
}
