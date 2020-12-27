<?php

declare(strict_types=1);

namespace Admin\Service\Role;

use App\Domain\Service\User\Role\Store as Service;

/**
 * 角色保存状态.
 */
class Store
{
    public function __construct(private Service $service)
    {
    }

    public function handle(array $input): array
    {
        return $this->service->handle($input);
    }
}
