<?php

declare(strict_types=1);

namespace Admin\App\Service\Role;

use Common\Domain\Service\User\Role\Show as Service;

/**
 * 角色查询.
 */
class Show
{
    public function __construct(private Service $service)
    {
    }

    public function handle(array $input): array
    {
        return $this->service->handle($input);
    }
}
