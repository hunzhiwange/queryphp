<?php

declare(strict_types=1);

namespace Admin\Service\User;

use App\Domain\Service\User\User\ChangePassword as Service;
use App\Domain\Service\User\User\ChangePasswordParams;

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
        $params = new ChangePasswordParams($input);

        return $this->service->handle($params);
    }
}
