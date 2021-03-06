<?php

declare(strict_types=1);

namespace Admin\Service\Resource;

use App\Domain\Service\User\Resource\Store as Service;

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
        $input['status'] = (int) $input['status'];
        
        return $this->service->handle($input);
    }
}
