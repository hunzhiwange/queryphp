<?php

declare(strict_types=1);

namespace App\Project\Controller\ApiQL\V1\ProjectIssue;

use App\Controller\Support\Controller;
use App\Project\Service\ProjectIssue\Update as Service;
use App\Project\Service\ProjectIssue\UpdateParams;
use Leevel\Http\Request;

/**
 * 项目问题完成或者取消.
 *
 * @codeCoverageIgnore
 */
class Complete
{
    use Controller;

    private array $allowedInput = [
        'id',
        'completed',
    ];

    /**
     * @throws \Exception
     */
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
