<?php

declare(strict_types=1);

namespace Admin\App\Service\Role;

use Common\Domain\Service\User\Role\Update as Service;

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
        return $this->service->handle($input);
    }
}
