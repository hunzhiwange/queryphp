<?php

declare(strict_types=1);

namespace Admin\Service\User;

use App\Domain\Service\User\User\Update as Service;
use App\Domain\Service\User\User\UpdateParams;

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
        if (isset($input['userRole'])) {
            $input['userRole'] = array_map(fn(string|int $v) => (int) $v, $input['userRole']);
        }
        $params = new UpdateParams($input);
        
        return $this->service->handle($params);
    }
}
