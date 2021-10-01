<?php

declare(strict_types=1);

namespace App\Controller\Api\V1\ProjectIssue;

use App\Controller\Support\Controller;
use App\Domain\Service\Project\ProjectIssue\Update as Service;
use App\Domain\Service\Project\ProjectIssue\UpdateParams;
use Leevel\Http\Request;

/**
 * 项目问题更新.
 *
 * @codeCoverageIgnore
 */
class Update
{
    use Controller;

    private array $allowedInput = [
        'id',
        'title',
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
