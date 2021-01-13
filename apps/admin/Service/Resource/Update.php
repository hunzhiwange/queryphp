<?php

declare(strict_types=1);

namespace Admin\Service\Resource;

use App\Domain\Service\User\Resource\Update as Service;

/**
 * 资源更新状态.
 */
class Update
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
