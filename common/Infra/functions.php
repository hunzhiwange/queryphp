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

use Common\Infra\Proxy\Permission;

if (!function_exists('permission')) {
    /**
     * 校验权限.
     *
     * @param string      $resource
     * @param null|string $method
     *
     * @return bool
     */
    function permission(string $resource, ?string $method = null): bool
    {
        return Permission::handle($resource, $method);
    }
}
