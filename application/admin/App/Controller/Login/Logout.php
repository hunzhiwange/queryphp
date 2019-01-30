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

use Admin\App\Service\Login\Logout as Service;

/**
 * 用户登出.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.11.22
 *
 * @version 1.0
 */
class Logout
{
    /**
     * 响应方法.
     *
     * @param \Admin\App\Service\Login\Logout $service
     */
    public function handle(Service $service): array
    {
        $service->handle();

        return [];
    }
}
