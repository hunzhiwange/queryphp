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

namespace Admin\App\Controller\User;

use Admin\App\Service\User\Info as service;

/**
 * 当前登陆用户查询.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2019.04.24
 *
 * @version 1.0
 */
class Info
{
    /**
     * 响应方法.
     *
     * @param \Admin\App\Service\User\Info $service
     *
     * @return array
     */
    public function handle(Service $service): array
    {
        return $service->handle();
    }
}
