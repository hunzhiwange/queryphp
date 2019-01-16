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

use Admin\App\Service\User\Lock as service;
use Leevel\Auth\Facade\Auth;
use Leevel\Http\IRequest;

/**
 * 锁定管理面板.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.11.21
 *
 * @version 1.0
 */
class Lock
{
    /**
     * 响应方法.
     *
     * @param \Leevel\Http\IRequest        $request
     * @param \Admin\App\Service\User\Lock $service
     *
     * @return array
     */
    public function handle(IRequest $request, Service $service): array
    {
        return $service->handle(['token' => $this->token()]);
    }

    /**
     * 获取 Token.
     *
     * @return string
     */
    protected function token(): string
    {
        return Auth::getTokenName();
    }
}
