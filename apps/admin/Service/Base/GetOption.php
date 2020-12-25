<?php

declare(strict_types=1);

namespace Admin\Service\Base;

use App\Domain\Service\Base\GetOption as Service;

/**
 * 获取配置服务.
 */
class GetOption
{
    public function __construct(private Service $service)
    {
    }

    public function handle(): array
    {
        return $this->service->handle();
    }
}
