<?php

declare(strict_types=1);

namespace Admin\App\Service\User;

use Common\Domain\Service\User\User\Lock as Service;

/**
 * 面板锁定服务.
 */
class Lock
{
    public function __construct(private Service $service)
    {
    }

    public function handle(array $input): array
    {
        return $this->service->handle($input);
    }
}
