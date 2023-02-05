<?php

declare(strict_types=1);

namespace App\Controller\Api\V1\Login;

use App\Domain\Service\Login\Logout as Service;

/**
 * 用户登出.
 *
 * @codeCoverageIgnore
 */
class Logout
{
    public function handle(Service $service): array
    {
        return success($service->handle(), __('登出成功'));
    }
}
