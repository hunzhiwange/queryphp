<?php

declare(strict_types=1);

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
