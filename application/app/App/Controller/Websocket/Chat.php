<?php

declare(strict_types=1);

namespace App\App\Controller\Websocket;

use Leevel\Router\Proxy\View;

/**
 * Websocket tests.
 *
 * @codeCoverageIgnore
 */
class Chat
{
    /**
     * 默认方法.
     */
    public function handle(): string
    {
        return View::display('websocket/chat');
    }
}
