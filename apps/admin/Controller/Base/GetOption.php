<?php

declare(strict_types=1);

namespace Admin\Controller\Base;

use App\Domain\Service\Base\Options;
use Leevel\Http\Request;

/**
 * 获取配置.
 *
 * @codeCoverageIgnore
 */
class GetOption
{
    public function handle(Request $request, Options $service): array
    {
        return $service->handle();
    }
}
