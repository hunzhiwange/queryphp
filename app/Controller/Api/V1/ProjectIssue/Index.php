<?php

declare(strict_types=1);

namespace App\Controller\Api\V1\ProjectIssue;

use App\Controller\Support\Controller;
use App\Domain\Service\Project\ProjectIssue\ProjectIssues as Service;
use App\Domain\Service\Project\ProjectIssue\ProjectIssuesParams;
use Leevel\Http\Request;

/**
 * 项目问题列表.
 *
 * @codeCoverageIgnore
 */
class Index
{
    use Controller;

    private array $allowedInput = [
        'key',
        'page',
        'size',
        'column',
        'order_by',
        'user_id',
        'type',
        'project_ids',
    ];

    public function handle(Request $request, Service $service): array
    {
        $input = $this->input($request);
        if (isset($input['type'])) {
            $input['user_id'] = $this->userId();
        }
        $params = new ProjectIssuesParams($input);

        return $service->handle($params);
    }
}
