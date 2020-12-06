<?php

declare(strict_types=1);

namespace Admin\App\Controller\Login;

use Admin\App\Service\Login\Logout as Service;

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
