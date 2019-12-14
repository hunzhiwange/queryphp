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

namespace Admin\App\Controller\Permission;

use Admin\App\Service\Permission\Index as Service;

/**
 * 权限列表.
 *
 * @codeCoverageIgnore
 */
class Index
{
    /**
     * 响应方法.
     */
    public function handle(Service $service): array
    {
        return $service->handle();
    }
}
