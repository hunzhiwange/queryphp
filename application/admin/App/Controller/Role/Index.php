<?php

declare(strict_types=1);

namespace Admin\App\Controller\Role;

use Admin\App\Controller\Support\Controller;
use Admin\App\Service\Role\Index as Service;
use Leevel\Http\Request;

/**
 * 角色列表.
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
