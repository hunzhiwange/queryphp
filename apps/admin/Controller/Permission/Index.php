<?php

declare(strict_types=1);

namespace Admin\Controller\Permission;

use App\Domain\Service\User\Permission\Tree as Service;

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
