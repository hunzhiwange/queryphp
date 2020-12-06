<?php

declare(strict_types=1);

namespace Admin\App\Controller\Permission;

use Admin\App\Controller\Support\Controller;
use Admin\App\Service\Permission\Destroy as Service;
use Leevel\Http\Request;

/**
 * 权限删除.
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
