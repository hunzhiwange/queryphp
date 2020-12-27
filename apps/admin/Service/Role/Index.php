<?php

declare(strict_types=1);

namespace Admin\Service\Role;

use App\Domain\Service\User\Role\Index as Service;

/**
 * 角色列表.
 */
class Index
{
    public function __construct(private Service $service)
    {
    }

    public function handle(array $input): array
    {
        return $this->service->handle($input);
    }
}
