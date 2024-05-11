<?php

declare(strict_types=1);

namespace App\Project\Controller\ApiQL\V1\ProjectTag;

use App\Controller\Support\Controller;
use App\Project\Service\ProjectTag\Destroy as Service;
use App\Project\Service\ProjectTag\DestroyParams;
use Leevel\Http\Request;

/**
 * 项目标签删除.
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
