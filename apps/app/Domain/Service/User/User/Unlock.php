<?php

declare(strict_types=1);

namespace App\Domain\Service\User\User;

use App\Domain\Entity\User\User;
use App\Exceptions\UserBusinessException;
use App\Exceptions\UserErrorCode;
use App\Infra\Lock;
use App\Infra\Repository\User\User as UserReposity;
use Leevel\Database\Ddd\UnitOfWork;
use Leevel\Validate\Proxy\Validate as Validates;

/**
 * 解锁管理面板.
 */
class Unlock
{
    public function __construct(private UnitOfWork $w, private Lock $lock)
    {
        $this->lock = $lock;
    }

    public function handle(UnlockParams $params): array
    {
        $this->validateArgs($params);
        $this->validateUser($params->id, $params->password);
        $this->unlock($params->token);

        return [];
    }

    /**
     * 解锁.
     */
    private function unlock(string $token): void
    {
        $this->lock->delete($token);
    }

    /**
     * 校验用户.
     */
    private function validateUser(int $id, string $password): void
    {
        $userReposity = $this->userReposity();
        $user = $userReposity->findValidUserById($id, 'id,password');
        $userReposity->verifyPassword($password, $user->password);
    }

    private function userReposity(): UserReposity
    {
        return $this->w->repository(User::class);
    }

    /**
     * 校验基本参数.
     *
     * @throws \App\Exceptions\UserBusinessException
     */
    private function validateArgs(UnlockParams $params): void
    {
        $validator = Validates::make(
            $params->toArray(),
            [
                'id'                   => 'required',
                'token'                => 'required',
                'password'             => 'required|alpha_dash|min_length:6',
            ],
            [
                'id'                   => 'ID',
                'token'                => 'Token',
                'password'             => __('解锁密码'),
            ]
        );

        if ($validator->fail()) {
            $e = json_encode($validator->error(), JSON_UNESCAPED_UNICODE);

            throw new UserBusinessException(UserErrorCode::UNLOCK_ANAGEMENT_PANEL_INVALID_ARGUMENT, $e, true);
        }
    }
}
