<?php

declare(strict_types=1);

namespace Admin\Controller\Role;

use Admin\Controller\Support\Controller;
use Admin\Service\Role\Update as Service;
use Leevel\Http\Request;

/**
 * 角色更新.
 *
 * @codeCoverageIgnore
 */
class Update
{
    use Controller;

    private array $allowedInput = [
        'id',
        'name',
        'num',
        'status',
    ];

    public function handle(Request $request, Service $service): array
    {
        return $this->main($request, $service);
    }

    private function extendInput(Request $request): array
    {
        return $this->restfulInput($request);
    }
}
