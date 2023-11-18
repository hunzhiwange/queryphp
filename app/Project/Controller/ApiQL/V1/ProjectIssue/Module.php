<?php

declare(strict_types=1);

namespace App\Project\Controller\ApiQL\V1\ProjectIssue;

use App\Controller\Support\Controller;
use App\Project\Service\ProjectIssue\Update as Service;
use App\Project\Service\ProjectIssue\UpdateParams;
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
