<?php

declare(strict_types=1);

namespace App\Controller\Support;

use Leevel\Auth\Proxy\Auth;
use Leevel\Http\Request;
use Leevel\Router\IRouter;

/**
 * 控制器.
 */
trait Controller
{
    private function input(Request $request): array
    {
        $input = $request->only($this->allowedInput);
        if (!method_exists($this, 'extendInput')) {
            return $input;
        }

        return array_merge($input, $this->extendInput($request));
    }

    private function restfulInput(Request $request): array
    {
        return [
            'id' => (int) $request->attributes->get(IRouter::RESTFUL_ID),
        ];
    }

    /**
     * 获取用户 ID.
     */
    private function userId(): int
    {
        return Auth::getLogin()['id'];
    }
}
