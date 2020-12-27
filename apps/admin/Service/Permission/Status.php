<?php

declare(strict_types=1);

namespace Admin\Service\Permission;

use App\Domain\Service\User\Permission\Status as Service;

/**
 * 批量设置权限状态.
 */
class Status
{
    public function __construct(private Service $service)
    {
    }

    public function handle(array $input): array
    {
        return $this->service->handle($input);
    }
}
