<?php

declare(strict_types=1);

namespace Admin\App\Controller\Login;

use Admin\App\Controller\Support\Controller;
use Admin\App\Service\Login\Validate as Service;
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
