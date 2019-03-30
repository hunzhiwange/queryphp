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

use Leevel\Http\IRequest;
use Leevel\Router\IRouter;

/**
 * 控制器.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2019.03.17
 *
 * @version 1.0
 */
trait Controller
{
    /**
     * 调用服务.
     *
     * @param \Leevel\Http\IRequest $request
     * @param object                $service
     *
     * @return array
     */
    private function main(IRequest $request, $service): array
    {
        return $service->handle($this->input($request));
    }

    /**
     * 输入数据.
     *
     * @param \Leevel\Http\IRequest $request
     *
     * @return array
     */
    private function input(IRequest $request): array
    {
        $input = $request->only($this->allowedInput);

        if (method_exists($this, 'extendInput')) {
            $input = array_merge($input, $this->extendInput($request));
        }

        return $input;
    }

    /**
     * Restful 输入数据.
     *
     * @param \Leevel\Http\IRequest $request
     *
     * @return array
     */
    private function restfulInput(IRequest $request): array
    {
        return [
            'id' => (int) ($request->params->get(IRouter::RESTFUL_ID)),
        ];
    }
}
