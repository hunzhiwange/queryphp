<?php

declare(strict_types=1);

namespace Admin\Service\User;

use App\Domain\Service\User\User\Store as Service;
use App\Domain\Service\User\User\StoreParams;
use Leevel\Collection\TypedIntArray;

/**
 * 用户保存.
 */
class Store
{
    public function __construct(private Service $service)
    {
    }

    public function handle(array $input): array
    {
        $input['status'] = (int) $input['status'];
        $input['userRole'] = TypedIntArray::fromRequest($input['userRole'] ?? []);
        $params = new StoreParams($input);

        return $this->service->handle($params);
    }
}
