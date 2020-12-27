<?php

declare(strict_types=1);

namespace Admin\Controller\User;

use  Admin\Controller\Support\Controller;
use  Admin\Service\User\Destroy as Service;
use Leevel\Http\Request;

/**
 * 用户删除.
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
