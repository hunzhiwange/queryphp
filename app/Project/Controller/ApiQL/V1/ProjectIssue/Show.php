<?php

declare(strict_types=1);

namespace App\Project\Controller\ApiQL\V1\ProjectIssue;

use App\Controller\Support\Controller;
use App\Project\Service\ProjectIssue\Show as Service;
use Leevel\Http\Request;

/**
 * 项目任务查询.
 *
 * @codeCoverageIgnore
 */
class Show
{
    use Controller;

    private array $allowedInput = [
        'num',
    ];

    public function handle(Request $request, Service $service): array
    {
        $params = new \App\Project\Service\ProjectIssue\ShowParams($this->input($request));

        return $service->handle($params);
    }
}
