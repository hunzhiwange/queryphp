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

namespace Admin\App\Controller\Base;

use Admin\App\Service\Base\GetOption as service;
use Leevel\Http\IRequest;

/**
 * 获取配置.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2018.12.03
 *
 * @version 1.0
 */
class GetOption
{
    /**
     * 响应方法.
     *
     * @param \Leevel\Http\IRequest             $request
     * @param \Admin\App\Service\Base\GetOption $service
     *
     * @return array
     */
    public function handle(IRequest $request, Service $service): array
    {
        return $service->handle();
    }
}
