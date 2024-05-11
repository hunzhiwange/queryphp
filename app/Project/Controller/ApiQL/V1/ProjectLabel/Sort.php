<?php

declare(strict_types=1);

namespace App\Project\Controller\ApiQL\V1\ProjectLabel;

use App\Controller\Support\Controller;
use App\Project\Service\ProjectLabel\Sort as Service;
use Leevel\Http\Request;

/**
 * 项目分类排序.
 *
 * @codeCoverageIgnore
 */
class Sort
{
    use Controller;

    private array $allowedInput = [
        'project_id',
        'project_label_ids',
    ];

    public function handle(Request $request, Service $service): array
    {
        $params = new \App\Project\Service\ProjectLabel\SortParams($this->input($request));

        return $service->handle($params);
    }
}
