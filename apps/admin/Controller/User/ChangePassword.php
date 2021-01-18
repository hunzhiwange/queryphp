<?php

declare(strict_types=1);

namespace Admin\Controller\User;

use Admin\Controller\Support\Controller;
use Admin\Service\User\ChangePassword as Service;
use Leevel\Auth\Proxy\Auth;
use Leevel\Http\Request;

/**
 * 用户修改密码.
 *
 * @codeCoverageIgnore
 */
class ChangePassword
{
    use Controller;

    private array $allowedInput = [
        'old_pwd',
        'new_pwd',
        'confirm_pwd',
    ];

    public function handle(Request $request, Service $service): array
    {
        return $this->main($request, $service);
    }

    private function extendInput(): array
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
