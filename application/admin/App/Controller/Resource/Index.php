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

namespace Admin\App\Controller\Resource;

use Admin\App\Service\Resource\Index as service;
use Leevel\Http\Request;

/**
 * 验证登录.
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
     * @param \admin\app\service\login\check $oService
     * @param \admin\is\seccode\code         $oCode
     *
     * @return array
     */
    public function handle(Request $request, Service $service)
    {
        return $service->handle($this->input($request));
    }

    /**
     * POST 数据.
     *
     * @param mixed $request
     *
     * @return array
     */
    protected function input($request)
    {
        return $request->only([
            'key',
            'status',
            'page',
            'size',
        ]);
    }
}
