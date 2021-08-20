<?php

declare(strict_types=1);

namespace App\Controller\Api\V1\Project;

use App\Controller\Support\Controller;
use App\Domain\Service\Project\Project\Projects as Service;
use App\Domain\Service\Project\Project\ProjectsParams;
use Leevel\Http\Request;

/**
 * 项目列表.
 *
 * @codeCoverageIgnore
 */
class Index
{
    use Controller;

    private array $allowedInput = [
        'key',
        'status',
        'page',
        'size',
        'column',
        'order_by',
        'user_id',
        'type',
    ];

    public function handle(Request $request, Service $service): array
    {
        $input = $this->input($request);
        $params = new ProjectsParams($input);

        return $service->handle($params);
    }
}
