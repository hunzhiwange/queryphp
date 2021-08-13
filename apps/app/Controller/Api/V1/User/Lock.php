<?php

declare(strict_types=1);

namespace App\Controller\Api\V1\User;

use App\Controller\Support\Controller;
use App\Domain\Service\User\User\Lock as Service;
use App\Domain\Service\User\User\LockParams;
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
        $params = new LockParams($this->input($request));

        return $service->handle($params);
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
