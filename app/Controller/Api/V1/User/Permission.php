<?php

declare(strict_types=1);

namespace App\Controller\Api\V1\User;

use App\Controller\Support\Controller;
use App\Domain\Service\User\User\Permission as Service;
use App\Domain\Service\User\User\PermissionParams;
use Leevel\Http\Request;

/**
 * 用户权限获取.
 *
 * @codeCoverageIgnore
 */
class Permission
{
    use Controller;

    private array $allowedInput = [
        'token',
        'refresh',
    ];

    public function handle(Request $request, Service $service): array
    {
        $params = new PermissionParams($this->input($request));

        return $service->handle($params);
    }

    private function extendInput(Request $request): array
    {
        return ['id' => $this->userId()];
    }
}
