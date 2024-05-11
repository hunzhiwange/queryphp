<?php

declare(strict_types=1);

namespace App\Project\Controller\ApiQL\V1\ProjectIssue;

use App\Controller\Support\Controller;
use App\Project\Service\ProjectIssue\Update as Service;
use Leevel\Http\Request;

/**
 * 项目问题版本更新.
 *
 * @codeCoverageIgnore
 */
class Release
{
    use Controller;

    private array $allowedInput = [
        'id',
        'releases',
    ];

    /**
     * @throws \Exception
     */
    public function handle(Request $request, Service $service): array
    {
        $input = $this->input($request);
        if (!isset($input['releases'])) {
            $input['releases'] = [];
        }
        $params = new \App\Project\Service\ProjectIssue\UpdateParams($input);

        return $service->handle($params);
    }

    private function extendInput(Request $request): array
    {
        return $this->restfulInput($request);
    }
}
