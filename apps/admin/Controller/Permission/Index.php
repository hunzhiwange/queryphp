<?php

declare(strict_types=1);

namespace Admin\Controller\Permission;

use Admin\Controller\Support\Controller;
use App\Domain\Service\User\Permission\Tree as Service;
use App\Domain\Service\User\Permission\TreeParams;
use Leevel\Http\Request;

/**
 * 权限列表.
 *
 * @codeCoverageIgnore
 */
class Index
{
    use Controller;

    private array $allowedInput = [
        'status',
    ];

    public function handle(Request $request, Service $service): array
    {
        $params = new TreeParams($this->input($request));

        return $service->handle($params);
    }
}
