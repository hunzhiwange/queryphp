<?php

declare(strict_types=1);

namespace App\Controller\Api\V1\Project;

use App\Controller\Support\Controller;
use App\Domain\Service\Project\Project\Store as Service;
use App\Domain\Service\Project\Project\StoreParams;
use Leevel\Http\Request;

/**
 * 项目保存.
 *
 * @codeCoverageIgnore
 */
class Store
{
    use Controller;

    private array $allowedInput = [
        'name',
        'num',
        'status',
        'template',
    ];

    public function handle(Request $request, Service $service): array
    {
        $params = new StoreParams($this->input($request));

        return $service->handle($params);
    }
}
