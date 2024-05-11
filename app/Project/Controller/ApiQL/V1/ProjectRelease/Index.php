<?php

declare(strict_types=1);

namespace App\Project\Controller\ApiQL\V1\ProjectRelease;

use App\Controller\Support\Controller;
use App\Project\Service\ProjectRelease\ProjectReleases as Service;
use App\Project\Service\ProjectRelease\ProjectReleasesParams;
use Leevel\Http\Request;

/**
 * 项目版本列表.
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
        $input = $this->input($request);
        $params = new ProjectReleasesParams($input);

        return $service->handle($params);
    }
}
