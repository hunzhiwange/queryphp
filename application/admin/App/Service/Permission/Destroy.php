<?php

declare(strict_types=1);

namespace Admin\App\Service\Permission;

use Common\Domain\Service\User\Permission\Destroy as Service;

/**
 * 权限删除状态.
 */
class Destroy
{
    public function __construct(private Service $service)
    {
    }

    public function handle(array $input): array
    {
        return $this->service->handle($input);
    }
}
