<?php

declare(strict_types=1);

namespace App\Controller\Api\V1\ProjectType;

use App\Controller\Support\Controller;
use App\Domain\Service\Project\ProjectType\Store as Service;
use App\Domain\Service\Project\ProjectType\StoreParams;
use Leevel\Http\Request;

/**
 * 项目类型保存.
 *
 * @codeCoverageIgnore
 */
class Store
{
    use Controller;

    private array $allowedInput = [
        'name',
        'num',
        'icon',
        'content_type',
        'sort',
        'status',
        'color',
    ];

    public function handle(Request $request, Service $service): array
    {
        $params = new StoreParams($this->input($request));

        return $service->handle($params);
    }
}
