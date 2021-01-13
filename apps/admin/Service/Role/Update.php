<?php

declare(strict_types=1);

namespace Admin\Service\Role;

use App\Domain\Service\User\Role\Update as Service;

/**
 * 角色更新状态.
 */
class Update
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
