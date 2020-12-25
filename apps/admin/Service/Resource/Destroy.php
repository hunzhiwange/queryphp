<?php

declare(strict_types=1);

namespace Admin\Service\Resource;

use App\Domain\Service\User\Resource\Destroy as Service;

/**
 * 资源删除状态.
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
