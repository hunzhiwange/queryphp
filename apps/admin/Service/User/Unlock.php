<?php

declare(strict_types=1);

namespace Admin\Service\User;

use App\Domain\Service\User\User\Unlock as Service;

/**
 * 面板解锁服务.
 */
class Unlock
{
    public function __construct(private Service $service)
    {
    }

    public function handle(array $input): array
    {
        return $this->service->handle($input);
    }
}
