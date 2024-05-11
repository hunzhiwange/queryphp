<?php

declare(strict_types=1);

namespace App\Project\Controller\ApiQL\V1\ProjectModule;

use App\Controller\Support\Controller;
use App\Project\Service\ProjectModule\Store as Service;
use App\Project\Service\ProjectModule\StoreParams;
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
