<?php

declare(strict_types=1);

namespace App\Controller\Api\V1\ProjectIssue;

use App\Controller\Support\Controller;
use App\Domain\Service\Project\ProjectIssue\Sort as Service;
use App\Domain\Service\Project\ProjectIssue\SortParams;
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

    public function handle(Request $request, Service $service): array
    {
        $params = new SortParams($this->input($request));

        return $service->handle($params);
    }
}
