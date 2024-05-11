<?php

declare(strict_types=1);

namespace App\Project\Controller\ApiQL\V1\ProjectModule;

use App\Controller\Support\Controller;
use App\Project\Service\ProjectModule\ProjectModules as Service;
use App\Project\Service\ProjectModule\ProjectModulesParams;
use Leevel\Http\Request;

/**
 * 项目模块列表.
 *
 * @codeCoverageIgnore
 */
class Index
{
    use Controller;

    private array $allowedInput = [];

    public function handle(Request $request, Service $service): array
    {
        $input = $this->input($request);
        $params = new ProjectModulesParams($input);

        return $service->handle($params);
    }
}
