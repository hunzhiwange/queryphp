<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Domain\Service\Login\LoginInfo as Service;

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
