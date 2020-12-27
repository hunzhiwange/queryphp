<?php

declare(strict_types=1);

namespace Admin\Service\Permission;

use App\Domain\Service\User\Permission\Destroy as Service;

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
