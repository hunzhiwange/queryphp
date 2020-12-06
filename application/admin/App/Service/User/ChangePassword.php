<?php

declare(strict_types=1);

namespace Admin\App\Service\User;

use Common\Domain\Service\User\User\ChangePassword as Service;

/**
 * 用户修改密码服务.
 */
class ChangePassword
{
    public function __construct(private Service $service)
    {
    }

    public function handle(array $input): array
    {
        return $this->service->handle($input);
    }
}
