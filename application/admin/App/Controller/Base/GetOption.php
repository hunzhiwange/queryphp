<?php

declare(strict_types=1);

namespace Admin\App\Controller\Base;

use Admin\App\Service\Base\GetOption as Service;
use Leevel\Http\Request;

/**
 * 获取配置.
 *
 * @codeCoverageIgnore
 */
class GetOption
{
    public function handle(Request $request, Service $service): array
    {
        return $service->handle();
    }
}
