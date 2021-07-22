<?php

declare(strict_types=1);

namespace Admin\Controller\User;

use Admin\Controller\Support\Controller;
use App\Domain\Service\User\User\UpdateInfo as Service;
use App\Domain\Service\User\User\UpdateInfoParams;
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
        $params = new UpdateInfoParams($this->input($request));

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
