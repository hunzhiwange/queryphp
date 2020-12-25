<?php

declare(strict_types=1);

namespace Admin\Controller\Resource;

use  Admin\Controller\Support\Controller;
use  Admin\Service\Resource\Status as Service;
use Leevel\Http\Request;

/**
 * 批量修改资源状态.
 *
 * @codeCoverageIgnore
 */
class Status
{
    use Controller;

    private array $allowedInput = [
        'ids',
        'status',
    ];

    public function handle(Request $request, Service $service): array
    {
        return $this->main($request, $service);
    }
}
