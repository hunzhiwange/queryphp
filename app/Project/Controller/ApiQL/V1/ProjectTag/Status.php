<?php

declare(strict_types=1);

namespace App\Project\Controller\ApiQL\V1\ProjectTag;

use App\Controller\Support\Controller;
use App\Project\Service\ProjectTag\Status as Service;
use Leevel\Http\Request;

/**
 * 批量修改项目标签状态.
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
        $params = new \App\Project\Service\ProjectTag\StatusParams($this->input($request));

        return $service->handle($params);
    }
}
