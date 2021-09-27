<?php

declare(strict_types=1);

namespace App\Controller\Api\V1\ProjectIssue;

use App\Controller\Support\Controller;
use App\Domain\Service\Project\ProjectIssue\Store as Service;
use App\Domain\Service\Project\ProjectIssue\StoreParams;
use Leevel\Http\Request;

/**
 * 项目问题保存.
 *
 * @codeCoverageIgnore
 */
class Store
{
    use Controller;

    private array $allowedInput = [
        'project_id',
        'project_label_id',
        'project_type_id',
        'title',
    ];

    public function handle(Request $request, Service $service): array
    {
        $params = new StoreParams($this->input($request));

        return $service->handle($params);
    }
}
