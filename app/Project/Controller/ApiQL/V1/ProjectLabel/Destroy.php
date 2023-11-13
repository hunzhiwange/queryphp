<?php

declare(strict_types=1);

namespace App\Project\Controller\ApiQL\V1\ProjectLabel;

use App\Controller\Support\Controller;
use App\Project\Service\ProjectLabel\Destroy as Service;
use Leevel\Http\Request;

/**
 * 项目分类删除.
 *
 * @codeCoverageIgnore
 */
class Destroy
{
    use Controller;

    public function handle(Request $request, Service $service): array
    {
        $params = new \App\Project\Service\ProjectLabel\DestroyParams($this->input($request));

        return $service->handle($params);
    }

    private function input(Request $request): array
    {
        return $this->restfulInput($request);
    }
}
