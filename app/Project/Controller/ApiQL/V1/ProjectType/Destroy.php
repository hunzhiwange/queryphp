<?php

declare(strict_types=1);

namespace App\Project\Controller\ApiQL\V1\ProjectType;

use App\Controller\Support\Controller;
use App\Project\Service\ProjectType\Destroy as Service;
use App\Project\Service\ProjectType\DestroyParams;
use Leevel\Http\Request;

/**
 * 项目类型删除.
 *
 * @codeCoverageIgnore
 */
class Destroy
{
    use Controller;

    public function handle(Request $request, Service $service): array
    {
        $params = new DestroyParams($this->input($request));

        return $service->handle($params);
    }

    private function input(Request $request): array
    {
        return $this->restfulInput($request);
    }
}
