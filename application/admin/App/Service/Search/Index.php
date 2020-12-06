<?php

declare(strict_types=1);

namespace Admin\App\Service\Search;

use Common\Domain\Service\Search\Index as Service;

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
