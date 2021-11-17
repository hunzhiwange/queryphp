<?php

declare(strict_types=1);

namespace App\Service\Search;

use App\Domain\Service\Search\Search as Service;

/**
 * 搜索项.
 */
class Search
{
    public function __construct(private Service $service)
    {
    }

    public function handle(array $input): array
    {
        return $this->service->handle($input);
    }
}
