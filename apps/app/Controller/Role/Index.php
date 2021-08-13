<?php

declare(strict_types=1);

namespace App\Controller\Role;

use App\Controller\Support\Controller;
use App\Domain\Service\User\Role\Roles as Service;
use App\Domain\Service\User\Role\RolesParams;
use Leevel\Http\Request;

/**
 * 角色列表.
 *
 * @codeCoverageIgnore
 */
class Index
{
    use Controller;

    private array $allowedInput = [
        'key',
        'status',
        'page',
        'size',
    ];

    public function handle(Request $request, Service $service): array
    {
        $input = $this->input($request);
        $params = new RolesParams($input);

        return $service->handle($params);
    }
}
