<?php

declare(strict_types=1);

namespace Admin\App\Service\Permission;

use Common\Domain\Service\User\Permission\Index as Service;

/**
 * 权限列表.
 */
class Index
{
    public function __construct(private Service $service)
    {
    }

    public function handle(): array
    {
        return $this->service->handle();
    }
}
