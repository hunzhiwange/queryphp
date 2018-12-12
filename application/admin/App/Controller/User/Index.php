<?php

declare(strict_types=1);

/*
 * This file is part of the forcodepoem package.
 *
 * The PHP Application Created By Code Poem. <Query Yet Simple>
 * (c) 2018-2099 http://forcodepoem.com All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Admin\App\Controller\User;

use Admin\App\Service\User\Index as service;
use Leevel\Http\Request;

/**
 * 用户列表.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.11.22
 *
 * @version 1.0
 */
class Index
{
    /**
     * 响应方法.
     *
     * @param \Leevel\Http\Request          $request
     * @param \Admin\App\Service\User\Index $service
     *
     * @return array
     */
    public function handle(Request $request, Service $service): array
    {
        return $service->handle($this->input($request));
    }

    /**
     * 输入数据.
     *
     * @param \Leevel\Http\Request $request
     *
     * @return array
     */
    protected function input(Request $request): array
    {
        return $request->only([
            'key',
            'status',
            'page',
            'size',
        ]);
    }
}
