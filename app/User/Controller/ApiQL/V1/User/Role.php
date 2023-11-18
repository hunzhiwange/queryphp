<?php

declare(strict_types=1);

namespace App\User\Controller\ApiQL\V1\User;

use App\User\Service\User\Role as Service;
use App\User\Service\User\RoleParams;
use Leevel\Http\Request;

/**
 * 用户授权角色.
 *
 * @codeCoverageIgnore
 */
class Role
{
    public function handle(Request $request, Service $service): array
    {
        $params = new RoleParams($request->all());

        return $service->handle($params);
    }
}
