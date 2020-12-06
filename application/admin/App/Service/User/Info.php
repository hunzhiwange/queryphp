<?php

declare(strict_types=1);

namespace Admin\App\Service\User;

use Leevel\Auth\Proxy\Auth;

/**
 * 当前登陆用户查询.
 */
class Info
{
    public function handle(): array
    {
        return Auth::getLogin();
    }
}
