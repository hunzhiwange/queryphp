<?php

declare(strict_types=1);

namespace App\Domain\Service\User\User;

use App\Domain\Entity\User\User;
use App\Infra\Lock;
use App\Infra\Repository\User\User as UserReposity;
use Leevel\Database\Ddd\UnitOfWork;

/**
 * 解锁管理面板.
 */
class Unlock
{
    public function __construct(private UnitOfWork $w, private Lock $lock)
    {
    }

    /**
     * @throws \Exception
     */
    public function handle(UnlockParams $params): array
    {
        $params->validate();
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
     *
     * @throws \Exception
     */
    private function validateUser(int $id, string $password): void
    {
        $userRepository = $this->userRepository();
        $user = $userRepository->findValidUserById($id, 'id,password');
        $userRepository->verifyPassword($password, $user->password);
    }

    private function userRepository(): UserReposity
    {
        return $this->w->repository(User::class);
    }
}
