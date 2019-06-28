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

namespace Admin\App\Controller\Login;

use Admin\App\Controller\Support\Controller;
use Admin\App\Service\Login\Code as Service;
use Leevel\Http\IRequest;
use Leevel\Http\Response;

/**
 * 验证码.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.11.22
 *
 * @version 1.0
 */
class Code
{
    use Controller;

    /**
     * 响应方法.
     *
     * @param \Leevel\Http\IRequest         $request
     * @param \Admin\App\Service\Login\Code $service
     *
     * @return \Leevel\Http\Response
     */
    public function handle(IRequest $request, Service $service): Response
    {
        $code = $service->handle($this->input($request));

        return new Response($code, 200, ['Content-type' => 'image/png']);
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
        return [
            'id' => $request->query->get('id'),
        ];
    }
}
