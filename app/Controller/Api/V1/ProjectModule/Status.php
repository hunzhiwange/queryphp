<?php

declare(strict_types=1);

namespace App\Controller\Api\V1\ProjectModule;

use App\Controller\Support\Controller;
use App\Domain\Service\Project\ProjectModule\Status as Service;
use App\Domain\Service\Support\StatusParams;
use Leevel\Http\Request;

/**
 * 批量修改项目模块状态.
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
        $params = new StatusParams($this->input($request));

        return $service->handle($params);
    }
}
