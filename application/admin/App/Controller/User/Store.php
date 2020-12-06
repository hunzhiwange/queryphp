<?php

declare(strict_types=1);

namespace Admin\App\Controller\User;

use Admin\App\Controller\Support\Controller;
use Admin\App\Service\User\Store as Service;
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
        return $this->main($request, $service);
    }
}
