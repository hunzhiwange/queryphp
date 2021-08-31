<?php

declare(strict_types=1);

namespace App\Controller\Api\V1\ProjectTag;

use App\Controller\Support\Controller;
use App\Domain\Service\Project\ProjectTag\Update as Service;
use App\Domain\Service\Project\ProjectTag\UpdateParams;
use Leevel\Http\Request;

/**
 * 项目标签更新.
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
        $params = new UpdateParams($this->input($request));

        return $service->handle($params);
    }

    private function extendInput(Request $request): array
    {
        return $this->restfulInput($request);
    }
}
