<?php

declare(strict_types=1);

namespace Admin\Service\Permission;

use App\Domain\Service\User\Permission\Store as Service;

/**
 * 权限保存状态.
 */
class Store
{
    public function __construct(private Service $service)
    {
    }

    public function handle(array $input): array
    {
        $input['status'] = (int) $input['status'];
        
        return $this->service->handle($input);
    }
}
