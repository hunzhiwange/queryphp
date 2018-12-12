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

namespace Admin\App\Controller\Base;

use Admin\App\Service\Base\Option as service;
use Leevel\Http\Request;

/**
 * 配置更新.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2018.12.03
 *
 * @version 1.0
 */
class Option
{
    /**
     * 响应方法.
     *
     * @param \Leevel\Http\Request           $request
     * @param \Admin\App\Service\Base\Option $service
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
            'site_name',
            'site_close',
        ]);
    }
}
