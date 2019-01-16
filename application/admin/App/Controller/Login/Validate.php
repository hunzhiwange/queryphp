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

namespace Admin\App\Controller\Login;

use Admin\App\Service\Login\Validate as Service;
use Leevel\Http\IRequest;

/**
 * 验证登录.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.11.22
 *
 * @version 1.0
 */
class Validate
{
    /**
     * 响应方法.
     *
     * @param \Leevel\Http\IRequest             $request
     * @param \Admin\App\Service\Login\Validate $service
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
            'app_id',
            'app_key',
            'name',
            'password',
            'remember',
            'code',
        ]);
    }
}
