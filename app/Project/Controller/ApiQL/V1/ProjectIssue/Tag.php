<?php

declare(strict_types=1);

namespace App\Project\Controller\ApiQL\V1\ProjectIssue;

use App\Controller\Support\Controller;
use App\Project\Service\ProjectIssue\Update as Service;
use Leevel\Http\Request;

/**
 * 项目问题标签更新.
 *
 * @codeCoverageIgnore
 */
class Tag
{
    use Controller;

    private array $allowedInput = [
        'id',
        'tags',
    ];

    /**
     * @throws \Exception
     */
    public function handle(Request $request, Service $service): array
    {
        $input = $this->input($request);
        if (!isset($input['tags'])) {
            $input['tags'] = [];
        }
        $params = new \App\Project\Service\ProjectIssue\UpdateParams($input);

        return $service->handle($params);
    }

    private function extendInput(Request $request): array
    {
        return $this->restfulInput($request);
    }
}
