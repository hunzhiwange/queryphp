<?php

declare(strict_types=1);

namespace Admin\Service\User;

use App\Domain\Service\User\User\Permission as Service;

/**
 * 用户权限数据服务.
 */
class Permission
{
    public function __construct(private Service $service)
    {
    }

    public function handle(array $input): array
    {
        return $this->service->handle($input);
    }
}
