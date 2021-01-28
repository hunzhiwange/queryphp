<?php

declare(strict_types=1);

namespace Admin\Controller\User;

use Admin\Controller\Support\Controller;
use App\Domain\Service\User\User\Destroy as Service;
use App\Domain\Service\Support\DestroyParams;
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
        $params = new DestroyParams($this->input($request));

        return $service->handle($params);
    }

    private function input(Request $request): array
    {
        return $this->restfulInput($request);
    }
}
