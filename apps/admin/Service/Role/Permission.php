<?php

declare(strict_types=1);

namespace Admin\Service\Role;

use App\Domain\Service\User\Role\Permission as Service;

/**
 * 角色授权.
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
