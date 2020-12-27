<?php

declare(strict_types=1);

namespace Admin\Controller\Permission;

use  Admin\Controller\Support\Controller;
use  Admin\Service\Permission\Resource as Service;
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
        return $this->main($request, $service);
    }
}
