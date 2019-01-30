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

namespace Common\Infra\Facade;

use Leevel\Support\Facade;

/**
 * 门面 Permission.
 *
 * @author Xiangmin Liu <635750556@qq.com>
 *
 * @since 2017.08.29
 *
 * @version 1.0
 */
class Permission extends Facade
{
    /**
     * 返回门面名字.
     *
     * @return string
     */
    protected static function name(): string
    {
        return 'permission';
    }
}
