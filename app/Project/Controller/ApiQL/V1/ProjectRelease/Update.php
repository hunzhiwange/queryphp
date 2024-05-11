<?php

declare(strict_types=1);

namespace App\Project\Controller\ApiQL\V1\ProjectRelease;

use App\Controller\Support\Controller;
use App\Project\Service\ProjectRelease\Update as Service;
use App\Project\Service\ProjectRelease\UpdateParams;
use Leevel\Http\Request;

/**
 * 项目版本更新.
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

        return $service->handle($params)->toArray();
    }

    private function extendInput(Request $request): array
    {
        return $this->restfulInput($request);
    }
}
