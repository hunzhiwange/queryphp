<?php

declare(strict_types=1);

namespace Admin\Controller\Role;

use Admin\Controller\Support\Controller;
use Admin\Service\Role\Store as Service;
use Leevel\Http\Request;

/**
 * 角色保存.
 *
 * @codeCoverageIgnore
 */
class Store
{
    use Controller;

    private array $allowedInput = [
        'name',
        'num',
        'status',
    ];

    public function handle(Request $request, Service $service): array
    {
        return $this->main($request, $service);
    }
}
