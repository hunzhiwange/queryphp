<?php

declare(strict_types=1);

namespace Admin\Service\Search;

use App\Domain\Service\Search\Index as Service;

/**
 * 搜索服务.
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
