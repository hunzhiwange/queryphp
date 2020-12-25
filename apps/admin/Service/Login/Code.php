<?php

declare(strict_types=1);

namespace Admin\Service\Login;

use App\Domain\Service\Login\Code as Service;

/**
 * 验证生成服务.
 */
class Code
{
    public function __construct(private Service $service)
    {
    }

    public function handle(array $input): string
    {
        return $this->service->handle($input);
    }
}
