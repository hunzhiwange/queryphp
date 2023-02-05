<?php

declare(strict_types=1);

namespace App\Domain\Service\User\User;

use App\Domain\Entity\User\User;
use App\Infra\Repository\User\User as UserReposity;
use Leevel\Database\Ddd\UnitOfWork;

/**
 * 用户修改密码.
 */
class ChangePassword
{
    public function __construct(private UnitOfWork $w)
    {
    }

    public function handle(ChangePasswordParams $params): array
    {
        $params->validate();
        $this->validateUser($params);
        $this->save($params);

        return [];
    }

    /**
     * 校验用户.
     */
    private function validateUser(ChangePasswordParams $params): void
    {
        $userRepository = $this->userRepository();
        $user = $userRepository->findValidUserById($params->id, 'id,password');
        $userRepository->verifyPassword($params->oldPwd, $user->password);
    }

    /**
     * 创建密码.
     */
    private function createPassword(string $password): string
    {
        return $this->userRepository()->createPassword($password);
    }

    private function userRepository(): UserReposity
    {
        return $this->w->repository(User::class);
    }

    /**
     * 保存.
     */
    private function save(ChangePasswordParams $params): User
    {
        $this->w->persist($entity = $this->entity($params));
        $this->w->flush();

        return $entity;
    }

    private function entity(ChangePasswordParams $params): User
    {
        $entity = $this->find($params->id);
        $entity->password = $this->createPassword($params->newPwd);

        return $entity;
    }

    /**
     * 查找实体.
     */
    private function find(int $id): User
    {
        return $this->w
            ->repository(User::class)
            ->findOrFail($id)
        ;
    }
}
