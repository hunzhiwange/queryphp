<?php

declare(strict_types=1);

namespace App\Controller\Permission;

use App\Controller\Support\Controller;
use App\Domain\Service\User\Permission\Resource as Service;
use App\Domain\Service\User\Permission\ResourceParams;
use Leevel\Http\Request;

/**
 * 权限授权资源.
 *
 * @codeCoverageIgnore
 */
class Resource
{
    use Controller;

    private array $allowedInput = [
        'id',
        'resource_id',
    ];

    public function handle(Request $request, Service $service): array
    {
        $params = new ResourceParams($this->input($request));

        return $service->handle($params);
    }
}
