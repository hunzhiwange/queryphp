<?php

declare(strict_types=1);

namespace App\Project\Controller\ApiQL\V1\Project;

use App\Controller\Support\Controller;
use App\Project\Service\Project\Projects as Service;
use App\Project\Service\Project\ProjectsParams;
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
        $params = new ProjectsParams($input);

        return $service->handle($params);
    }
}
