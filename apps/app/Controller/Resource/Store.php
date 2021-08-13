<?php

declare(strict_types=1);

namespace App\Controller\Resource;

use App\Controller\Support\Controller;
use App\Domain\Service\User\Resource\Store as Service;
use App\Domain\Service\User\Resource\StoreParams;
use Leevel\Http\Request;

/**
 * 资源保存.
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
        $params = new StoreParams($this->input($request));

        return $service->handle($params);
    }
}
