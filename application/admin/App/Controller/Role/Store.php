<?php

declare(strict_types=1);

namespace Admin\App\Controller\Role;

use Admin\App\Controller\Support\Controller;
use Admin\App\Service\Role\Store as Service;
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
