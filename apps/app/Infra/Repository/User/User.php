<?php

declare(strict_types=1);

namespace App\Infra\Repository\User;

use App\Domain\Entity\User\User as EntityUser;
use App\Exceptions\UserBusinessException;
use App\Exceptions\UserErrorCode;
use Closure;
use Leevel\Auth\Hash;
use Leevel\Database\Ddd\Repository;
use Leevel\Database\Ddd\Select;

/**
 * 用户仓储.
 */
class User extends Repository
{
    /**
     * 通过用户名查找可用用户.
     */
    public function findValidUserByName(string $name, string $column = '*'): EntityUser
    {
        return $this->findValidUserByCondition(
            fn (Select $select) => $select->where('name', $name),
            $column,
        );
    }

    /**
     * 通过用户 ID 查找可用用户.
     */
    public function findValidUserById(int $id, string $column = '*'): EntityUser
    {
        return $this->findValidUserByCondition(
            fn (Select $select) => $select->where('id', $id),
            $column,
        );
    }

    /**
     * 通过条件查找可用用户.
     *
     * @throws \App\Exceptions\UserBusinessException
     */
    public function findValidUserByCondition(Closure $condition, string $column = '*'): EntityUser
    {
        $select = $this->entity
            ->select()
            ->where('status', EntityUser::STATUS_ENABLE)
            ->columns($column);
        $condition($select);
        $user = $select->findOne();
        if (!$user->id) {
            throw new UserBusinessException(UserErrorCode::ACCOUNT_NOT_EXIST_OR_DISABLED);
        }

        return $user;
    }

    /**
     * 校验密码.
     *
     * @throws \App\Exceptions\UserBusinessException
     */
    public function verifyPassword(string $password, string $hash): void
    {
        if (!(new Hash())->verify($password, $hash)) {
            throw new UserBusinessException(UserErrorCode::ACCOUNT_PASSWORD_ERROR);
        }
    }

    /**
     * 创建密码.
     */
    public function createPassword(string $password): string
    {
        return (new Hash())->password($password);
    }

    /**
     * 校验用户.
     *
     * @throws \App\Exceptions\UserBusinessException
     */
    public function verifyUsersByIds(array $userIds, ?Closure $condition = null): void
    {
        $userIds = array_unique($userIds);
        $select = $this->whereIn('id', $userIds);
        if ($condition) {
            $condition($select);
        }
        $users = $select->findAll();
        if (count($userIds) !== count($users)) {
            throw new UserBusinessException(UserErrorCode::SOME_USERS_DOES_NOT_EXIST);
        }
    }
}
