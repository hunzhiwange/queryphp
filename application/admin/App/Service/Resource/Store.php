<?php

declare(strict_types=1);

namespace Admin\App\Service\Resource;

use Common\Domain\Service\User\Resource\Store as Service;

/**
 * 资源保存状态.
 */
class Store
{
    public function __construct(private Service $service)
    {
    }

    public function handle(array $input): array
    {
        return $this->service->handle($input);
    }
}
