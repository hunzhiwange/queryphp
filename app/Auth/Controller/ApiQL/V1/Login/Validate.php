<?php

declare(strict_types=1);

namespace App\Auth\Controller\ApiQL\V1\Login;

use App\Auth\Service\Login as Service;
use App\Auth\Service\LoginParams;
use Leevel\Http\Request;

/**
 * 验证登录.
 *
 * @codeCoverageIgnore
 */
class Validate
{
    /**
     * @throws \Exception
     */
    public function handle(Request $request, Service $service): array
    {
        $params = new LoginParams($request->all());

        return success_message($service->handle($params), __('登陆成功'));
    }
}
