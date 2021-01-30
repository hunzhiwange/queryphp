<?php

declare(strict_types=1);

namespace Admin\Controller\User;

use Admin\Controller\Support\Controller;
use App\Domain\Service\User\User\Store as Service;
use App\Domain\Service\User\User\StoreParams;
use Leevel\Http\Request;

/**
 * 用户保存.
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
        'userRole',
        'password',
    ];

    public function handle(Request $request, Service $service): array
    {
        $params = new StoreParams($this->input($request));

        return $service->handle($params);
    }
}
