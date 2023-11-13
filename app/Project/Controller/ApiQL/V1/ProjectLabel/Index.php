<?php

declare(strict_types=1);

namespace App\Project\Controller\ApiQL\V1\ProjectLabel;

use App\Controller\Support\Controller;
use App\Project\Service\ProjectLabel\ProjectLabels as Service;
use App\Project\Service\ProjectLabel\ProjectLabelsParams;
use Leevel\Http\Request;

/**
 * 项目分类列表.
 *
 * @codeCoverageIgnore
 */
class Index
{
    use Controller;

    private array $allowedInput = [
        'project_ids',
    ];

    public function handle(Request $request, Service $service): array
    {
        $params = new ProjectLabelsParams($this->input($request));

        return $service->handle($params);
    }
}
