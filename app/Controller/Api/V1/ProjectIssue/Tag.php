<?php

declare(strict_types=1);

namespace App\Controller\Api\V1\ProjectIssue;

use App\Controller\Support\Controller;
use App\Domain\Service\Project\ProjectIssue\Update as Service;
use App\Domain\Service\Project\ProjectIssue\UpdateParams;
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

    public function handle(Request $request, Service $service): array
    {
        $input = $this->input($request);
        if (!isset($input['tags'])) {
            $input['tags'] = [];
        }
        $params = new UpdateParams($input);

        return $service->handle($params);
    }

    private function extendInput(Request $request): array
    {
        return $this->restfulInput($request);
    }
}
