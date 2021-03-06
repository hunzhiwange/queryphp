<?php

declare(strict_types=1);

namespace Admin\Service\User;

use App\Domain\Service\User\User\UpdateInfo as Service;

/**
 * 用户修改资料.
 */
class UpdateInfo
{
    public function __construct(private Service $service)
    {
    }

    public function handle(array $input): array
    {
        return $this->service->handle($input);
    }
}
