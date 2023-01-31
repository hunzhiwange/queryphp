<?php

declare(strict_types=1);

namespace App\Controller\Api\V1\ProjectLabel;

use App\Controller\Support\Controller;
use App\Domain\Service\Project\ProjectLabel\ProjectLabels as Service;
use App\Domain\Service\Project\ProjectLabel\ProjectLabelsParams;
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
        'key',
        'page',
        'size',
        'column',
        'order_by',
        'project_ids',
    ];

    public function handle(Request $request, Service $service): array
    {
        $params = new ProjectLabelsParams($this->input($request));

        return $service->handle($params);
    }
}
