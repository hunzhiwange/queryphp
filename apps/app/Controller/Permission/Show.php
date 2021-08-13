<?php

declare(strict_types=1);

namespace App\Controller\Permission;

use App\Controller\Support\Controller;
use App\Domain\Service\User\Permission\Show as Service;
use App\Domain\Service\User\Permission\ShowParams;
use Leevel\Http\Request;

/**
 * 权限查询.
 *
 * @codeCoverageIgnore
 */
class Show
{
    use Controller;

    public function handle(Request $request, Service $service): array
    {
        $params = new ShowParams($this->input($request));

        return $service->handle($params);
    }

    private function input(Request $request): array
    {
        return $this->restfulInput($request);
    }
}
