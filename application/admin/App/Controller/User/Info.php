<?php

declare(strict_types=1);

namespace Admin\App\Controller\User;

use Admin\App\Service\User\Info as Service;

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
