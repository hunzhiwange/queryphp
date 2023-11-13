<?php

declare(strict_types=1);

namespace App\Config\Controller\ApiQL\V1;

use App\Config\Service\OptionUpdate;
use App\Config\Service\OptionUpdateParams;
use Leevel\Http\Request;

/**
 * 配置更新.
 *
 * @codeCoverageIgnore
 */
class Option
{
    public function handle(Request $request, OptionUpdate $service): array
    {
        $params = new OptionUpdateParams($request->all());

        return $service->handle($params);
    }
}
