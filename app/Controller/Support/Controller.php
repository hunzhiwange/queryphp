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
    protected array $remainingInput = [
        'key',
        'status',
        'page',
        'page_size',
        'column',
        'key_column',
        'where',
        'order_by',
        'group_by',
        'relation',
    ];

    private function input(Request $request): array
    {
        if (!empty($this->allowedInput)) {
            if (Request::METHOD_GET === $request->getMethod()) {
                $this->allowedInput = array_merge($this->allowedInput, $this->remainingInput);
            }
            $input = $request->only($this->allowedInput);
        } else {
            $input = $request->all();
        }

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
