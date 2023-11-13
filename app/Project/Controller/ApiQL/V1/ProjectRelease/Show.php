<?php

declare(strict_types=1);

namespace App\Project\Controller\ApiQL\V1\ProjectRelease;

use App\Controller\Support\Controller;
use App\Project\Service\ProjectRelease\Show as Service;
use Leevel\Http\Request;

/**
 * 项目版本查询.
 *
 * @codeCoverageIgnore
 */
class Show
{
    use Controller;

    public function handle(Request $request, Service $service): array
    {
        $params = new \App\Project\Service\ProjectRelease\ShowParams($this->input($request));

        return $service->handle($params);
    }

    private function input(Request $request): array
    {
        return $this->restfulInput($request);
    }
}
