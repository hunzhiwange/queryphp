<?php

declare(strict_types=1);

/*
 * This file is part of the your app package.
 *
 * The PHP Application For Code Poem For You.
 * (c) 2018-2099 http://yourdomian.com All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
     *
     * @param object $service
     */
    private function main(Request $request, $service): array
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
            'id' => (int) ($request->attributes->get(IRouter::RESTFUL_ID)),
        ];
    }
}
