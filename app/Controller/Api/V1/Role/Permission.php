<?php

declare(strict_types=1);

namespace App\Controller\Api\V1\Role;

use App\Controller\Support\Controller;
use App\Domain\Service\User\Role\Permission as Service;
use App\Domain\Service\User\Role\PermissionParams;
use Leevel\Http\Request;

/**
 * 角色授权权限.
 *
 * @codeCoverageIgnore
 */
class Permission
{
    use Controller;

    private array $allowedInput = [
        'id',
        'permission_id',
    ];

    public function handle(Request $request, Service $service): array
    {
        $params = new PermissionParams($this->input($request));

        return $service->handle($params);
    }
}
