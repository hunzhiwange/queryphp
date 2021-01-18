<?php

declare(strict_types=1);

namespace Admin\Controller\Login;

use Admin\Controller\Support\Controller;
use Admin\Service\Login\Validate as Service;
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
        return $this->main($request, $service);
    }
}
