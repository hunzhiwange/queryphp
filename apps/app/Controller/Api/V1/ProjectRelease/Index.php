<?php

declare(strict_types=1);

namespace App\Controller\Api\V1\ProjectRelease;

use App\Controller\Support\Controller;
use App\Domain\Service\Project\ProjectRelease\ProjectReleases as Service;
use App\Domain\Service\Project\ProjectRelease\ProjectReleasesParams;
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
        'key',
        'status',
        'page',
        'size',
        'project_ids',
    ];

    public function handle(Request $request, Service $service): array
    {
        $input = $this->input($request);
        $params = new ProjectReleasesParams($input);

        return $service->handle($params);;
    }
}
