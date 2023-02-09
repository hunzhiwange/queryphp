<?php

declare(strict_types=1);

namespace App\Controller\Api\V1\User;

use App\Controller\Support\Controller;
use App\Domain\Service\User\User\ChangePassword as Service;
use App\Domain\Service\User\User\ChangePasswordParams;
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

    /**
     * @throws \Exception
     */
    public function handle(Request $request, Service $service): array
    {
        $params = new ChangePasswordParams($this->input($request));

        return success($service->handle($params), __('修改密码后你需要从新登陆'));
    }

    private function extendInput(Request $request): array
    {
        return ['id' => $this->userId()];
    }
}
