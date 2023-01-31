<?php

declare(strict_types=1);

namespace App\Controller\Api\V1\User;

use App\Controller\Support\Controller;
use App\Domain\Service\User\User\Role as Service;
use App\Domain\Service\User\User\RoleParams;
use Leevel\Http\Request;

/**
 * 用户授权角色.
 *
 * @codeCoverageIgnore
 */
class Role
{
    use Controller;

    private array $allowedInput = [
        'id',
        'role_id',
    ];

    public function handle(Request $request, Service $service): array
    {
        $params = new RoleParams($this->input($request));

        return $service->handle($params);
    }
}
