<?php

declare(strict_types=1);

namespace App\User\Repository;

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
        return $this->findCount(function (Select $select) use ($id): void {
            $select->where('parent_id', $id);
        }) > 0;
    }
}
