<?php

declare(strict_types=1);

namespace Admin\App\Controller\User;

use Admin\App\Controller\Support\Controller;
use Admin\App\Service\User\UpdateInfo as Service;
use Leevel\Auth\Proxy\Auth;
use Leevel\Http\Request;

/**
 * 用户修改资料.
 *
 * @codeCoverageIgnore
 */
class UpdateInfo
{
    use Controller;

    private array $allowedInput = [
        'email',
        'mobile',
    ];

    public function handle(Request $request, Service $service): array
    {
        return $this->main($request, $service);
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
        return (int) Auth::getLogin()['id'];
    }
}
