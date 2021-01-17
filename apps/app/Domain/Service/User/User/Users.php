<?php

declare(strict_types=1);

namespace App\Domain\Service\User\User;

use Closure;
use App\Domain\Entity\User\User;
use App\Domain\Service\Support\Read;
use Leevel\Database\Ddd\Select;
use Leevel\Database\Ddd\UnitOfWork;

/**
 * 用户列表.
 */
class Users
{
    use Read;

    public function __construct(private UnitOfWork $w)
    {
    }

    public function handle(UsersParams $params): array
    {
        $repository = $this->w->repository(User::class);

        return $this->findPage($params, $repository);
    }

    /**
     * 准备用户数据.
     */
    private function prepareItem(User $user): array
    {
        $data = $user->toArray();
        $data['role'] = $user->role->toArray();

        return $data;
    }

    /**
     * 查询条件.
     */
    private function condition(UsersParams $params): Closure
    {
        return function (Select $select) use ($params) {
            $select->eager(['role']);
            $this->spec($select, $params);
        };
    }
}
