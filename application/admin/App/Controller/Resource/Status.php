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

namespace Admin\App\Controller\Resource;

use Admin\App\Service\Resource\Status as service;
use Leevel\Http\IRequest;

/**
 * 批量修改资源状态.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.10.23
 *
 * @version 1.0
 */
class Status
{
    /**
     * 响应方法.
     *
     * @param \Leevel\Http\IRequest                $request
     * @param \Admin\App\Service\Resource\Statuses $service
     *
     * @return array
     */
    public function handle(IRequest $request, Service $service): array
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
    protected function input(IRequest $request): array
    {
        return $request->only([
            'ids',
            'status',
        ]);
    }
}
