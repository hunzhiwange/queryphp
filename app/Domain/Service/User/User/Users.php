<?php

declare(strict_types=1);

namespace App\Domain\Service\User\User;

use App\Domain\Entity\User\User;
use App\Domain\Service\Support\Read;
use App\Domain\Service\Support\ReadParams;
use Leevel\Database\Ddd\Select;

/**
 * 用户列表.
 */
class Users
{
    use Read;

    protected string $entityClass = User::class;

    private function conditionCall(ReadParams $params): ?\Closure
    {
        return fn (Select $select) => $select->eager(['role']);
    }
}
