<?php

declare(strict_types=1);

namespace App\Config\Controller\ApiQL\V1;

use App\Config\Service\Options;

/**
 * 获取配置.
 *
 * @codeCoverageIgnore
 */
class GetOption
{
    public function handle(Options $service): array
    {
        return $service->handle();
    }
}
