<?php

declare(strict_types=1);

namespace Admin\Controller\Permission;

use Admin\Controller\Support\Controller;
use Admin\Service\Permission\Status as Service;
use Leevel\Http\Request;

/**
 * 批量修改权限状态.
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
