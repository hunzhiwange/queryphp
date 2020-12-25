<?php

declare(strict_types=1);

namespace Admin\Service\Permission;

use App\Domain\Service\User\Permission\Update as Service;

/**
 * 权限更新状态.
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
