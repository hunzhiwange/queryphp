<?php

declare(strict_types=1);

namespace App\Controller\Api\V1\ProjectRelease;

use App\Controller\Support\Controller;
use App\Domain\Service\Project\ProjectRelease\Store as Service;
use App\Domain\Service\Project\ProjectRelease\StoreParams;
use Leevel\Http\Request;

/**
 * 项目发行版保存.
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
        $params = new StoreParams($this->input($request));

        return $service->handle($params);
    }
}
