<?php

declare(strict_types=1);

namespace App\Controller\Api\V1\Permission;

use App\Controller\Support\Controller;
use App\Domain\Service\User\Permission\Update as Service;
use App\Domain\Service\User\Permission\UpdateParams;
use Leevel\Http\Request;

/**
 * 权限更新.
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
        'pid',
    ];

    public function handle(Request $request, Service $service): array
    {
        $params = new UpdateParams($this->input($request));

        return $service->handle($params);
    }

    private function extendInput(Request $request): array
    {
        return $this->restfulInput($request);
    }
}
