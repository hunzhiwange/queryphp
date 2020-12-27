<?php

declare(strict_types=1);

namespace Admin\Service\User;

use App\Domain\Service\User\User\Status as Service;

/**
 * 批量设置用户状态.
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
