<?php

declare(strict_types=1);

namespace App\Domain\Service\Login;

use Leevel\Auth\Proxy\Auth;

/**
 * 登陆信息.
 */
class LoginInfo
{
    public function handle(): array
    {
        return Auth::getLogin();
    }
}
