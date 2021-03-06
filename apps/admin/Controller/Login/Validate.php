<?php

declare(strict_types=1);

namespace Admin\Controller\Login;

use Admin\Controller\Support\Controller;
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
        'app_id',
        'app_key',
        'name',
        'password',
        'remember',
        'code',
    ];

    public function handle(Request $request, Service $service): array
    {
        $params = new LoginParams($request->toArray());

        return $service->handle($params);
    }
}
