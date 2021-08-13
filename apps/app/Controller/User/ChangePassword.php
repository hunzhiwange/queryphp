<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Controller\Support\Controller;
use Leevel\Auth\Proxy\Auth;
use Leevel\Http\Request;
use App\Domain\Service\User\User\ChangePassword as Service;
use App\Domain\Service\User\User\ChangePasswordParams;

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
        $params = new ChangePasswordParams($this->input($request));

        return $service->handle($params);
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
