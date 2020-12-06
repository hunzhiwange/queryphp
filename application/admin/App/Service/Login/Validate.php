<?php

declare(strict_types=1);

namespace Admin\App\Service\Login;

use Common\Domain\Service\Login\Validate as Service;

/**
 * 验证登陆服务.
 */
class Validate
{
    public function __construct(private Service $service)
    {
    }

    public function handle(array $input): array
    {
        return $this->service->handle($input);
    }
}
