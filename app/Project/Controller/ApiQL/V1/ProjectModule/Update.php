<?php

declare(strict_types=1);

namespace App\Project\Controller\ApiQL\V1\ProjectModule;

use App\Controller\Support\Controller;
use App\Project\Service\ProjectModule\Update as Service;
use Leevel\Http\Request;

/**
 * 项目模块更新.
 *
 * @codeCoverageIgnore
 */
class Update
{
    use Controller;

    private array $allowedInput = [
        'id',
        'name',
        'sort',
        'status',
        'color',
    ];

    public function handle(Request $request, Service $service): array
    {
        $params = new \App\Project\Service\ProjectModule\UpdateParams($this->input($request));

        return $service->handle($params);
    }

    private function extendInput(Request $request): array
    {
        return $this->restfulInput($request);
    }
}
