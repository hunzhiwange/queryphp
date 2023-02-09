<?php

declare(strict_types=1);

namespace App\Controller\Api\V1\ProjectIssue;

use App\Controller\Support\Controller;
use App\Domain\Service\Project\ProjectIssue\Update as Service;
use App\Domain\Service\Project\ProjectIssue\UpdateParams;
use Leevel\Http\Request;

/**
 * 项目问题模块更新.
 *
 * @codeCoverageIgnore
 */
class Module
{
    use Controller;

    private array $allowedInput = [
        'id',
        'modules',
    ];

    /**
     * @throws \Exception
     */
    public function handle(Request $request, Service $service): array
    {
        $input = $this->input($request);
        if (!isset($input['modules'])) {
            $input['modules'] = [];
        }
        $params = new UpdateParams($input);

        return $service->handle($params);
    }

    private function extendInput(Request $request): array
    {
        return $this->restfulInput($request);
    }
}
