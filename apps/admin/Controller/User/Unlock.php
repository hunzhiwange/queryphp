<?php

declare(strict_types=1);

namespace Admin\Controller\User;

use Admin\Controller\Support\Controller;
use App\Domain\Service\User\User\Unlock as Service;
use App\Domain\Service\User\User\UnlockParams;
use Leevel\Auth\Proxy\Auth;
use Leevel\Http\Request;

/**
 * 解锁管理面板.
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
        $params = new UnlockParams($this->input($request));

        return $service->handle($params);
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
