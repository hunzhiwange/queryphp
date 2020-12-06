<?php

declare(strict_types=1);

namespace Admin\App\Service\Base;

use Common\Domain\Service\Base\Option as Service;

/**
 * 配置更新服务.
 */
class Option
{
    public function __construct(private Service $service)
    {
    }

    public function handle(array $input): array
    {
        return $this->service->handle($input);
    }
}
