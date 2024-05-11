<?php

declare(strict_types=1);

namespace App\Project\Controller\ApiQL\V1\ProjectLabel;

use App\Controller\Support\Controller;
use App\Project\Service\ProjectLabel\Update as Service;
use App\Project\Service\ProjectLabel\UpdateParams;
use Leevel\Http\Request;

/**
 * 项目分类更新.
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
    ];

    public function handle(Request $request, Service $service): array
    {
        $params = new UpdateParams($this->input($request));

        return $service->handle($params);
    }

    private function extendInput(Request $request): array
    {
        return $this->restfulInput($request);
    }
}
