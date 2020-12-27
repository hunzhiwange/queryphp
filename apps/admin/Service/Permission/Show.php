<?php

declare(strict_types=1);

namespace Admin\Service\Permission;

use App\Domain\Service\User\Permission\Show as Service;

/**
 * 权限查询.
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
