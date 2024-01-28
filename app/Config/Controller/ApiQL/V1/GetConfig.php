<?php

declare(strict_types=1);

namespace App\Config\Controller\ApiQL\V1;

use App\Config\Service\Configs;

/**
 * 获取配置.
 *
 * @codeCoverageIgnore
 */
class GetConfig
{
    public function handle(Configs $service): array
    {
        return $service->handle();
    }
}
