<?php

declare(strict_types=1);

namespace App\Controller\Api\V1\Login;

use App\Controller\Support\Controller;
use App\Domain\Service\Login\Login as Service;
use App\Domain\Service\Login\LoginParams;
use Leevel\Http\Request;

/**
 * 验证登录.
 *
 * @codeCoverageIgnore
 */
class Validate
{
    use Controller;

    private array $allowedInput = [
        'app_key',
        'name',
        'password',
        'remember',
        'code',
    ];

    public function handle(Request $request, Service $service): array
    {
        $params = new LoginParams($request->toArray());

        return \success($service->handle($params), __('登陆成功'));
    }
}
