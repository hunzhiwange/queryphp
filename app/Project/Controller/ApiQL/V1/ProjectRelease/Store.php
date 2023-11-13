<?php

declare(strict_types=1);

namespace App\Project\Controller\ApiQL\V1\ProjectRelease;

use App\Controller\Support\Controller;
use App\Project\Service\ProjectRelease\Store as Service;
use Leevel\Http\Request;

/**
 * 项目版本保存.
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
        'project_id',
    ];

    public function handle(Request $request, Service $service): array
    {
        $params = new \App\Project\Service\ProjectRelease\StoreParams($this->input($request));

        return $service->handle($params);
    }
}
