<?php

declare(strict_types=1);

namespace Admin\Controller\Role;

use  Admin\Controller\Support\Controller;
use  Admin\Service\Role\Destroy as Service;
use Leevel\Http\Request;

/**
 * 角色删除.
 *
 * @codeCoverageIgnore
 */
class Destroy
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
