<?php

declare(strict_types=1);

namespace App\Project\Controller\ApiQL\V1\ProjectIssue;

use App\Controller\Support\Controller;
use App\Project\Service\ProjectIssue\ProjectIssues as Service;
use App\Project\Service\ProjectIssue\ProjectIssuesParams;
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
