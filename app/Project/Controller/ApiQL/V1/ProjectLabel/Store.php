<?php

declare(strict_types=1);

namespace App\Project\Controller\ApiQL\V1\ProjectLabel;

use App\Controller\Support\Controller;
use App\Project\Service\ProjectLabel\Store as Service;
use Leevel\Http\Request;

/**
 * 项目分类保存.
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
        $params = new \App\Project\Service\ProjectLabel\StoreParams($this->input($request));

        return $service->handle($params);
    }
}
