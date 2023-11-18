<?php

declare(strict_types=1);

namespace App\User\Controller\ApiQL\V1\Role;

use App\User\Service\Role\Permission as Service;
use App\User\Service\Role\PermissionParams;
use Leevel\Http\Request;

/**
 * 角色授权权限.
 *
 * @codeCoverageIgnore
 */
class Permission
{
    public function handle(Request $request, Service $service): array
    {
        $params = new PermissionParams($request->all());

        return $service->handle($params);
    }
}
