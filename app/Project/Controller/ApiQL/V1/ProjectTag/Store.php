<?php

declare(strict_types=1);

namespace App\Project\Controller\ApiQL\V1\ProjectTag;

use App\Controller\Support\Controller;
use App\Project\Service\ProjectTag\Store as Service;
use Leevel\Http\Request;

/**
 * 项目标签保存.
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
        $params = new \App\Project\Service\ProjectTag\StoreParams($this->input($request));

        return $service->handle($params);
    }
}
