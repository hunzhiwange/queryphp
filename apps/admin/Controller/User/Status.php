<?php

declare(strict_types=1);

namespace Admin\Controller\User;

use  Admin\Controller\Support\Controller;
use  Admin\Service\User\Status as Service;
use Leevel\Http\Request;

/**
 * 批量修改用户状态.
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
