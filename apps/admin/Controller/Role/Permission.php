<?php

declare(strict_types=1);

namespace Admin\Controller\Role;

use Admin\Controller\Support\Controller;
use Admin\Service\Role\Permission as Service;
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
        return $this->main($request, $service);
    }
}
