<?php

declare(strict_types=1);

namespace App\User\Controller\ApiQL\V1\User;

use App\User\Service\User\Unlock as Service;
use App\User\Service\User\UnlockParams;
use Leevel\Auth\Proxy\Auth;
use Leevel\Http\Request;

/**
 * 解锁管理面板.
 *
 * @codeCoverageIgnore
 */
class Unlock
{
    /**
     * @throws \Exception
     */
    public function handle(Request $request, Service $service): array
    {
        $params = new UnlockParams($request->all());
        $params->id = get_account_id();
        $params->token = Auth::getTokenName();

        return $service->handle($params);
    }
}
