<?php

declare(strict_types=1);

namespace App\Controller\Base;

use App\Domain\Service\Option\Options;

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
