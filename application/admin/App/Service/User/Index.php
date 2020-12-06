<?php

declare(strict_types=1);

namespace Admin\App\Service\User;

use Common\Domain\Service\User\User\Index as Service;

/**
 * 用户列表服务.
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
