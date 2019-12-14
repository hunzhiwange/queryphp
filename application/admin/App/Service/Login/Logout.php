<?php

declare(strict_types=1);

/*
 * This file is part of the your app package.
 *
 * The PHP Application For Code Poem For You.
 * (c) 2018-2099 http://yourdomian.com All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Admin\App\Service\Login;

use Leevel\Auth\Proxy\Auth;

/**
 * 用户登出.
 */
class Logout
{
    /**
     * 响应方法.
     */
    public function handle()
    {
        Auth::logout();
    }
}
