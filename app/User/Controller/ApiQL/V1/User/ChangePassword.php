<?php

declare(strict_types=1);

namespace App\User\Controller\ApiQL\V1\User;

use App\User\Service\User\ChangePassword as Service;
use App\User\Service\User\ChangePasswordParams;
use Leevel\Http\Request;

/**
 * 用户修改密码.
 *
 * @codeCoverageIgnore
 */
class ChangePassword
{
    /**
     * @throws \Exception
     */
    public function handle(Request $request, Service $service): array
    {
        $params = new ChangePasswordParams($request->all());
        $params->id = get_account_id();

        return success_message($service->handle($params), __('修改密码后你需要从新登陆'));
    }
}
