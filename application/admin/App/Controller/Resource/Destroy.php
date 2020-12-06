<?php

declare(strict_types=1);

namespace Admin\App\Controller\Resource;

use Admin\App\Controller\Support\Controller;
use Admin\App\Service\Resource\Destroy as Service;
use Leevel\Http\Request;

/**
 * 资源删除.
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
