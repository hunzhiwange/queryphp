<?php

declare(strict_types=1);

namespace Admin\Controller\Resource;

use  Admin\Controller\Support\Controller;
use  Admin\Service\Resource\Update as Service;
use Leevel\Http\Request;

/**
 * 资源更新.
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
