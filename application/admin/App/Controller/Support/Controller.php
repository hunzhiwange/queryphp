<?php

declare(strict_types=1);

namespace Admin\App\Controller\Support;

use Leevel\Http\Request;
use Leevel\Router\IRouter;

/**
 * 控制器.
 */
trait Controller
{
    /**
     * 调用服务.
     */
    private function main(Request $request, object $service): array
    {
        return $service->handle($this->input($request));
    }

    private function input(Request $request): array
    {
        $input = $request->only($this->allowedInput);

        if (method_exists($this, 'extendInput')) {
            $input = array_merge($input, $this->extendInput($request));
        }

        return $input;
    }

    private function restfulInput(Request $request): array
    {
        return [
            'id' => (int) $request->attributes->get(IRouter::RESTFUL_ID),
        ];
    }
}
