<?php

declare(strict_types=1);

namespace Admin\App\Controller\Permission;

use Admin\App\Service\Permission\Index as Service;

/**
 * 权限列表.
 *
 * @codeCoverageIgnore
 */
class Index
{
    public function handle(Service $service): array
    {
        return $service->handle();
    }
}
