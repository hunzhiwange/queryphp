<?php

declare(strict_types=1);

namespace Admin\Controller\User;

use  Admin\Controller\Support\Controller;
use  Admin\Service\User\Index as Service;
use Leevel\Http\Request;

/**
 * 用户列表.
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
        'column',
        'order_by',
    ];

    public function handle(Request $request, Service $service): array
    {
        return $this->main($request, $service);
    }
}
