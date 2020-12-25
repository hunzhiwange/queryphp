<?php

declare(strict_types=1);

namespace Admin\Controller\Resource;

use  Admin\Controller\Support\Controller;
use  Admin\Service\Resource\Index as Service;
use Leevel\Http\Request;

/**
 * 资源列表.
 *
 * @codeCoverageIgnore
 */
class Index
{
    use Controller;

    private array $allowedInput = [
        'key',
        'status',
        'page',
        'size',
    ];

    public function handle(Request $request, Service $service): array
    {
        return $this->main($request, $service);
    }
}
