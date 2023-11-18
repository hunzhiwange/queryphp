<?php

declare(strict_types=1);

namespace App\Project\Controller\ApiQL\V1\Project;

use App\Controller\Support\Controller;
use App\Project\Service\Project\Destroy as Service;
use Leevel\Http\Request;

/**
 * 项目删除.
 *
 * @codeCoverageIgnore
 */
class Destroy
{
    use Controller;

    public function handle(Request $request, Service $service): array
    {
        $params = new \App\Project\Service\Project\DestroyParams($this->input($request));

        return $service->handle($params);
    }

    private function input(Request $request): array
    {
        return $this->restfulInput($request);
    }
}
