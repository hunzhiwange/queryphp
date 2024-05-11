<?php

declare(strict_types=1);

namespace App\Config\Controller\ApiQL\V1;

use App\Config\Service\ConfigUpdate;
use App\Config\Service\ConfigUpdateParams;
use Leevel\Http\Request;

/**
 * 配置更新.
 *
 * @codeCoverageIgnore
 */
class Config
{
    public function handle(Request $request, ConfigUpdate $service): array
    {
        $params = new ConfigUpdateParams($request->all());

        return $service->handle($params);
    }
}
