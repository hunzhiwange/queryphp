<?php

declare(strict_types=1);

namespace App\Domain\Service\Login;

use Leevel\Auth\Proxy\Auth;

/**
 * 用户登出.
 */
class Logout
{
    public function handle(): array
    {
        Auth::logout();

        return [];
    }
}
