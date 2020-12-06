<?php

declare(strict_types=1);

namespace Admin\App\Service\Role;

use Common\Domain\Service\User\Role\Status as Service;

/**
 * 批量设置角色状态.
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
