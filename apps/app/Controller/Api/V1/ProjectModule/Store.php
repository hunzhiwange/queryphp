<?php

declare(strict_types=1);

namespace App\Controller\Api\V1\ProjectModule;

use App\Controller\Support\Controller;
use App\Domain\Service\Project\ProjectModule\Store as Service;
use App\Domain\Service\Project\ProjectModule\StoreParams;
use Leevel\Http\Request;

/**
 * 项目模块保存.
 *
 * @codeCoverageIgnore
 */
class Store
{
    use Controller;

    private array $allowedInput = [
        'name',
        'sort',
        'status',
        'color',
        'project_id',
    ];

    public function handle(Request $request, Service $service): array
    {
        $params = new StoreParams($this->input($request));

        return $service->handle($params);
    }
}
