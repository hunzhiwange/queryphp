<?php

declare(strict_types=1);

namespace Admin\Service\User;

use App\Domain\Service\User\User\Update as Service;
use App\Domain\Service\User\User\UpdateParams;
use Leevel\Collection\TypedIntArray;

/**
 * 用户更新.
 */
class Update
{
    public function __construct(private Service $service)
    {
    }

    public function handle(array $input): array
    {
        $input['status'] = (int) $input['status'];
        $input['userRole'] = TypedIntArray::fromRequest($input['userRole'] ?? []);
        $params = new UpdateParams($input);
        
        return $this->service->handle($params);
    }
}
