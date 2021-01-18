<?php

declare(strict_types=1);

namespace Admin\Controller\Login;

use Admin\Service\Login\Logout as Service;

/**
 * 用户登出.
 *
 * @codeCoverageIgnore
 */
class Logout
{
    public function handle(Service $service): array
    {
        $service->handle();

        return [];
    }
}
