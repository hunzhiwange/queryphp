<?php

declare(strict_types=1);

namespace Admin\App\Controller\Permission;

use Admin\App\Controller\Support\Controller;
use Admin\App\Service\Permission\Store as Service;
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
