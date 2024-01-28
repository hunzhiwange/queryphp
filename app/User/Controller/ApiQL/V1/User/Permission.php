<?php

declare(strict_types=1);

namespace App\User\Controller\ApiQL\V1\User;

use App\User\Service\User\Permission as Service;
use App\User\Service\User\PermissionParams;
use Leevel\Http\Request;

/**
 * 用户权限获取.
 *
 * @codeCoverageIgnore
 */
class Permission
{
    public function handle(Request $request, Service $service): array
    {
        $params = new PermissionParams($request->all());
        $params->id = get_account_id();

        return $service->handle($params);
    }
}
