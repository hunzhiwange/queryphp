<?php

declare(strict_types=1);

namespace Admin\App\Controller\User;

use Admin\App\Controller\Support\Controller;
use Admin\App\Service\User\Lock as Service;
use Leevel\Auth\Proxy\Auth;
use Leevel\Http\Request;

/**
 * 锁定管理面板.
 *
 * @codeCoverageIgnore
 */
class Lock
{
    use Controller;

    public function handle(Request $request, Service $service): array
    {
        return $this->main($request, $service);
    }

    private function input(Request $request): array
    {
        return ['token' => $this->token()];
    }

    /**
     * 获取 Token.
     */
    private function token(): string
    {
        return Auth::getTokenName();
    }
}
