<?php

declare(strict_types=1);

namespace App\Controller\Api\V1\ProjectLabel;

use App\Controller\Support\Controller;
use App\Domain\Service\Project\ProjectLabel\Store as Service;
use App\Domain\Service\Project\ProjectLabel\StoreParams;
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
        $params = new StoreParams($this->input($request));

        return $service->handle($params);
    }
}
