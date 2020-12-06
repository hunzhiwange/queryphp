<?php

declare(strict_types=1);

namespace Admin\App\Controller\Role;

use Admin\App\Controller\Support\Controller;
use Admin\App\Service\Role\Show as Service;
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
        return $this->main($request, $service);
    }

    private function input(Request $request): array
    {
        return $this->restfulInput($request);
    }
}
