<?php

declare(strict_types=1);

namespace Common\Domain\Service\User\User;

use Common\Domain\Entity\User\User;
use Common\Infra\Exception\BusinessException;
use Leevel\Auth\Hash;
use Leevel\Database\Ddd\UnitOfWork;
use Leevel\Validate\Proxy\Validate as Validates;

/**
 * 用户修改密码.
 */
class ChangePassword
{
    private array $input;

    public function __construct(private UnitOfWork $w, private Hash $hash)
    {
    }

    public function handle(array $input): array
    {
        $this->input = $input;
        $this->validateArgs();
        $this->validateUser();
        $this->save($input)->toArray();

        return [];
    }

    /**
     * 校验用户.
     *
     * @throws \Common\Infra\Exception\BusinessException
     */
    private function validateUser(): User
    {
        $user = User::select()
            ->where('status', '1')
            ->where('id', $this->input['id'])
            ->findOne();

        if (!$user->id) {
            throw new BusinessException(__('账号不存在或者已禁用'));
        }

        if (!$this->verifyPassword($this->input['old_pwd'], $user->password)) {
            throw new BusinessException(__('账户旧密码错误'));
        }

        return $user;
    }

    /**
     * 创建密码.
     */
    private function createPassword(string $password): string
    {
        return $this->hash->password($password);
    }

    /**
     * 校验旧密码.
     */
    private function verifyPassword(string $password, string $hash): bool
    {
        return $this->hash->verify($password, $hash);
    }

    /**
     * 保存.
     */
    private function save(array $input): User
    {
        $this->w->persist($entity = $this->entity($input));
        $this->w->flush();

        return $entity;
    }

    /**
     * 验证参数.
     */
    private function entity(array $input): User
    {
        $entity = $this->find((int) $input['id']);
        $entity->withProps($this->data($input));

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
     * 组装实体数据.
     */
    private function data(array $input): array
    {
        return [
            'password'       => $this->createPassword(trim($input['new_pwd'])),
        ];
    }

    /**
     * 校验基本参数.
     *
     * @throws \Common\Infra\Exception\BusinessException
     */
    private function validateArgs(): void
    {
        $validator = Validates::make(
            $this->input,
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

            throw new BusinessException($e);
        }
    }
}
