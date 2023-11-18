<?php

declare(strict_types=1);

namespace App\User\Controller\ApiQL\V1\Permission;

use App\User\Service\Permission\Resource as Service;
use App\User\Service\Permission\ResourceParams;
use Leevel\Http\Request;

/**
 * 权限授权资源.
 *
 * @codeCoverageIgnore
 */
class Resource
{
    public function handle(Request $request, Service $service): array
    {
        $params = new ResourceParams($request->all());

        return $service->handle($params);
    }
}
