<?php

declare(strict_types=1);

namespace App\Controller\Api\V1\ProjectModule;

use App\Controller\Support\Controller;
use App\Domain\Service\Project\ProjectModule\ProjectModules as Service;
use App\Domain\Service\Project\ProjectModule\ProjectModulesParams;
use Leevel\Http\Request;

/**
 * 项目模块列表.
 *
 * @codeCoverageIgnore
 */
class Index
{
    use Controller;

    private array $allowedInput = [
        'key',
        'status',
        'page',
        'size',
    ];

    public function handle(Request $request, Service $service): array
    {
        $input = $this->input($request);
        $params = new ProjectModulesParams($input);

        return $service->handle($params);
    }
}
