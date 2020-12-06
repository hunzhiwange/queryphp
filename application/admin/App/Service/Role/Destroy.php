<?php

declare(strict_types=1);

namespace Admin\App\Service\Role;

use Common\Domain\Service\User\Role\Destroy as Service;

/**
 * 角色删除状态.
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
