<?php

declare(strict_types=1);

namespace App\User\Service\User;

use App\User\Entity\User;
use Leevel\Database\Ddd\UnitOfWork;

/**
 * 用户修改密码.
 */
class ChangePassword
{
    public function __construct(private UnitOfWork $w)
    {
    }

    /**
     * @throws \Exception
     */
    public function handle(ChangePasswordParams $params): array
    {
        $params->validate();
        $this->validateUser($params);
        $this->save($params);

        return [];
    }

    /**
     * 校验用户.
     *
     * @throws \Exception
     */
    private function validateUser(ChangePasswordParams $params): void
    {
        $userRepository = User::repository();
        $user = $userRepository->findValidUserById($params->id, 'id,password');
        $userRepository->verifyPassword($params->oldPwd, $user->password);
    }

    /**
     * 创建密码.
     */
    private function createPassword(string $password): string
    {
        return User::repository()->createPassword($password);
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
            ->repository(\App\User\Entity\User::class)
            ->findOrFail($id)
        ;
    }
}
