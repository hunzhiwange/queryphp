<?php

declare(strict_types=1);

namespace App\Project\Controller\ApiQL\V1\ProjectIssue;

use App\Controller\Support\Controller;
use App\Project\Service\ProjectIssue\Sort as Service;
use Leevel\Http\Request;

/**
 * 问题排序.
 *
 * @codeCoverageIgnore
 */
class Sort
{
    use Controller;

    private array $allowedInput = [
        'prev_issue_id',
        'next_issue_id',
        'project_id',
        'project_label_id',
    ];

    /**
     * @throws \Exception
     */
    public function handle(Request $request, Service $service): array
    {
        $params = new \App\Project\Service\ProjectIssue\SortParams($this->input($request));

        return $service->handle($params);
    }
}
