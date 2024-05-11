<?php

declare(strict_types=1);

namespace App\Project\Controller\ApiQL\V1\ProjectRelease;

use App\Controller\Support\Controller;
use App\Project\Service\ProjectRelease\Status as Service;
use Leevel\Http\Request;

/**
 * 批量修改项目版本状态.
 *
 * @codeCoverageIgnore
 */
class Status
{
    use Controller;

    private array $allowedInput = [
        'ids',
        'status',
    ];

    /**
     * @throws \Exception
     */
    public function handle(Request $request, Service $service): array
    {
        $params = new \App\Project\Service\ProjectRelease\StatusParams($this->input($request));

        return $service->handle($params);
    }
}
