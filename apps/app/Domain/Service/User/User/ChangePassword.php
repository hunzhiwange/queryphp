<?php

declare(strict_types=1);

namespace App\Domain\Service\User\User;

use App\Domain\Entity\User\User;
use App\Exceptions\UserBusinessException;
use App\Exceptions\UserErrorCode;
use App\Infra\Repository\User\User as UserReposity;
use Leevel\Database\Ddd\UnitOfWork;
use Leevel\Validate\Proxy\Validate as Validates;

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
        $this->validateArgs($params);
        $this->validateUser($params);
        $this->save($params);

        return [];
    }

    /**
     * 校验用户.
     */
    private function validateUser(ChangePasswordParams $params): void
    {
        $userReposity = $this->userReposity();
        $user = $userReposity->findValidUserById($params->id, 'id,password');
        $userReposity->verifyPassword($params->oldPwd, $user->password);
    }

    /**
     * 创建密码.
     */
    private function createPassword(string $password): string
    {
        return $this->userReposity()->createPassword($password);
    }

    private function userReposity(): UserReposity
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
            ->findOrFail($id);
    }

    /**
     * 校验基本参数.
     *
     * @throws \App\Exceptions\BusinessException
     */
    private function validateArgs(ChangePasswordParams $params): void
    {
        $validator = Validates::make(
            $params->toArray(),
            [
                'id'                  => 'required',
                'old_pwd'             => 'required|alpha_dash|min_length:6',
                'new_pwd'             => 'required|alpha_dash|min_length:6',
                'confirm_pwd'         => 'required|alpha_dash|min_length:6|equal_to:new_pwd',
            ],
            [
                'id'                  => 'ID',
                'old_pwd'             => __('旧密码'),
                'new_pwd'             => __('新密码'),
                'confirm_pwd'         => __('确认密码'),
            ]
        );

        if ($validator->fail()) {
            $e = json_encode($validator->error(), JSON_UNESCAPED_UNICODE);

            throw new UserBusinessException(UserErrorCode::CHANGE_PASSWORD_INVALID_ARGUMENT, $e, true);
        }
    }
}
