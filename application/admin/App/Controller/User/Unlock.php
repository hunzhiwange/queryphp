<?php

declare(strict_types=1);

namespace Admin\App\Controller\User;

use Admin\App\Controller\Support\Controller;
use Admin\App\Service\User\Unlock as Service;
use Leevel\Auth\Proxy\Auth;
use Leevel\Http\Request;

/**
 * 解锁.
 *
 * @codeCoverageIgnore
 */
class Unlock
{
    use Controller;

    private array $allowedInput = [
        'password',
    ];

    public function handle(Request $request, Service $service): array
    {
        return $this->main($request, $service);
    }

    private function extendInput(Request $request): array
    {
        return [
            'id'    => $this->id(),
            'token' => $this->token(),
        ];
    }

    /**
     * 获取 Token.
     */
    private function token(): string
    {
        return Auth::getTokenName();
    }

    /**
     * 获取用户 ID.
     */
    private function id(): int
    {
        return (int) Auth::getLogin()['id'];
    }
}
