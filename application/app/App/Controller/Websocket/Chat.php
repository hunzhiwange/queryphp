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

namespace App\App\Controller\Websocket;

use Leevel\Router\Proxy\View;

/**
 * Websocket tests.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2018.12.20
 *
 * @version 1.0
 */
class Chat
{
    /**
     * 默认方法.
     *
     * @return string
     */
    public function handle(): string
    {
        return View::display('websocket/chat');
    }
}
