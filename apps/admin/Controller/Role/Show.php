<?php

declare(strict_types=1);

namespace Admin\Controller\Role;

use Admin\Controller\Support\Controller;
use App\Domain\Service\User\Role\Show as Service;
use App\Domain\Service\User\Role\ShowParams;
use Leevel\Http\Request;

/**
 * 角色查询.
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
