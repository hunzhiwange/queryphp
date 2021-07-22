<?php

declare(strict_types=1);

namespace Admin\Controller\Permission;

use Admin\Controller\Support\Controller;
use App\Domain\Service\User\Permission\Store as Service;
use App\Domain\Service\User\Permission\StoreParams;
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
        $params = new StoreParams($this->input($request));

        return $service->handle($params);
    }
}
