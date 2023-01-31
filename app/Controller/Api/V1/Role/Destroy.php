<?php

declare(strict_types=1);

namespace App\Controller\Api\V1\Role;

use App\Controller\Support\Controller;
use App\Domain\Service\Support\DestroyParams;
use App\Domain\Service\User\Role\Destroy as Service;
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
        $params = new DestroyParams($this->input($request));

        return $service->handle($params);
    }

    private function input(Request $request): array
    {
        return $this->restfulInput($request);
    }
}
