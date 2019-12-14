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

namespace Common\Domain\Service\User\Role;

use Common\Domain\Entity\User\Role;
use Common\Domain\Service\Support\Status as CommonStatus;

/**
 * 批量修改角色状态.
 */
class Status
{
    use CommonStatus;

    /**
     * 返回实体.
     */
    private function entity(): string
    {
        return Role::class;
    }
}
