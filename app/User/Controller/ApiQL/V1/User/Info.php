<?php

declare(strict_types=1);

namespace App\User\Controller\ApiQL\V1\User;

use App\Auth\Service\LoginInfo as Service;

/**
 * 当前登陆用户查询.
 *
 * @codeCoverageIgnore
 */
class Info
{
    public function handle(Service $service): array
    {
        return $service->handle();
    }
}
