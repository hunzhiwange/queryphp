<?php

declare(strict_types=1);

namespace Admin\Controller\Permission;

use  Admin\Controller\Support\Controller;
use  Admin\Service\Permission\Store as Service;
use Leevel\Http\Request;

/**
 * 权限保存.
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
        'pid',
    ];

    public function handle(Request $request, Service $service): array
    {
        return $this->main($request, $service);
    }
}
