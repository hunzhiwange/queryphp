<?php

declare(strict_types=1);

namespace Admin\Service\Login;

use Leevel\Auth\Proxy\Auth;

/**
 * 用户登出.
 */
class Logout
{
    public function handle(): void
    {
        Auth::logout();
    }
}
