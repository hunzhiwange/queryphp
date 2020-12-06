<?php

declare(strict_types=1);

namespace Admin\App\Service\Resource;

use Common\Domain\Service\User\Resource\Status as Service;

/**
 * 批量设置资源状态.
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
