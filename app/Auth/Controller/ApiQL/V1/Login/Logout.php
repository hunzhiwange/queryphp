<?php

declare(strict_types=1);

namespace App\Auth\Controller\ApiQL\V1\Login;

use App\Auth\Service\Logout as Service;

/**
 * 用户登出.
 *
 * @codeCoverageIgnore
 */
class Logout
{
    public function handle(Service $service): array
    {
        return success_message($service->handle(), __('登出成功'));
    }
}
