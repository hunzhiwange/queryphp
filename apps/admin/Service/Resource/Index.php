<?php

declare(strict_types=1);

namespace Admin\Service\Resource;

use App\Domain\Service\User\Resource\Index as Service;

/**
 * 资源列表.
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
