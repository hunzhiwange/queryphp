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

namespace Common\Infra\Repository\User;

use Leevel\Database\Ddd\Repository;
use Leevel\Database\Ddd\Select;

/**
 * 权限仓储.
 */
class Permission extends Repository
{
    /**
     * 是否存在子项.
     */
    public function hasChildren(int $id): bool
    {
        return $this->findCount(function (Select $select) use ($id) {
            $select->where('pid', $id);
        }) > 0;
    }
}
