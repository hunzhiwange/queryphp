<?php

declare(strict_types=1);

namespace Admin\Service\User;

use App\Domain\Service\User\User\Update as Service;

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
        return $this->service->handle($input);
    }
}
