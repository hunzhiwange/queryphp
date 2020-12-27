<?php

declare(strict_types=1);

namespace Admin\Service\User;

use App\Domain\Service\User\User\Destroy as Service;

/**
 * 用户删除服务.
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
