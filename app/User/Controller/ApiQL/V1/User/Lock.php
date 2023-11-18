<?php

declare(strict_types=1);

namespace App\User\Controller\ApiQL\V1\User;

use App\User\Service\User\Lock as Service;
use App\User\Service\User\LockParams;
use Leevel\Auth\Proxy\Auth;
use Leevel\Http\Request;

/**
 * 锁定管理面板.
 *
 * @codeCoverageIgnore
 */
class Lock
{
    public function handle(Request $request, Service $service): array
    {
        $params = new LockParams($request->all());
        $params->token = Auth::getTokenName();

        return $service->handle($params);
    }
}
