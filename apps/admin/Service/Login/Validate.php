<?php

declare(strict_types=1);

namespace Admin\Service\Login;

use App\Domain\Service\Login\Validate as Service;

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
