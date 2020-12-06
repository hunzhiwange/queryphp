<?php

declare(strict_types=1);

namespace Admin\App\Controller\User;

use Admin\App\Controller\Support\Controller;
use Admin\App\Service\User\Update as Service;
use Leevel\Http\Request;

/**
 * 用户更新.
 *
 * @codeCoverageIgnore
 */
class Update
{
    use Controller;

    private array $allowedInput = [
        'id',
        'num',
        'status',
        'userRole',
        'password',
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
