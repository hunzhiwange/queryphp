<?php

declare(strict_types=1);

namespace Admin\App\Service\Permission;

use Common\Domain\Service\User\Permission\Resource as Service;

/**
 * 权限资源授权.
 */
class Resource
{
    public function __construct(private Service $service)
    {
    }

    public function handle(array $input): array
    {
        return $this->service->handle($input);
    }
}
