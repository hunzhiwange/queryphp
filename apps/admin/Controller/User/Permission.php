<?php

declare(strict_types=1);

namespace Admin\Controller\User;

use Admin\Controller\Support\Controller;
use App\Domain\Service\User\User\Permission as Service;
use App\Domain\Service\User\User\PermissionParams;
use Leevel\Auth\Proxy\Auth;
use Leevel\Http\Request;

/**
 * 用户权限获取.
 *
 * @codeCoverageIgnore
 */
class Permission
{
    use Controller;

    private array $allowedInput = [
        'token',
        'refresh',
    ];

    public function handle(Request $request, Service $service): array
    {
        $params = new PermissionParams($this->input($request));

        return $service->handle($params);
    }

    private function extendInput(Request $request): array
    {
        return ['id' => $this->id()];
    }

    /**
     * 获取用户 ID.
     */
    private function id(): int
    {
        return Auth::getLogin()['id'];
    }
}
