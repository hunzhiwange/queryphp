<?php

declare(strict_types=1);

/*
 * This file is part of the your app package.
 *
 * The PHP Application For Code Poem For You.
 * (c) 2018-2099 http://yourdomian.com All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Common\Domain\Service\User\User;

use Common\Domain\Entity\User\User;
use Leevel\Auth\Hash;
use Leevel\Database\Ddd\IUnitOfWork;
use Leevel\Kernel\Exception\HandleException;
use Leevel\Validate\Facade\Validate as Validates;

/**
 * 用户修改密码.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.11.21
 *
 * @version 1.0
 */
class ChangePassword
{
    /**
     * 事务工作单元.
     *
     * @var \Leevel\Database\Ddd\IUnitOfWork
     */
    protected $w;

    /**
     * Hash 组件.
     *
     * @var \Leevel\Auth\Hash
     */
    protected $hash;

    /**
     * 输入数据.
     *
     * @var array
     */
    protected $input;

    /**
     * 构造函数.
     *
     * @param \Leevel\Database\Ddd\IUnitOfWork $w
     * @param \Leevel\Auth\Hash                $hash
     */
    public function __construct(IUnitOfWork $w, Hash $hash)
    {
        $this->w = $w;
        $this->hash = $hash;
    }

    /**
     * 响应方法.
     *
     * @param array $input
     *
     * @return array
     */
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
     * @return \Common\Domain\Entity\User\User
     */
    protected function validateUser(): User
    {
        $user = User::Where('status', '1')
            ->where('id', $this->input['id'])
            ->findOne();

        if (!$user->id) {
            throw new HandleException(__('账号不存在或者已禁用'));
        }

        if (!$this->verifyPassword($this->input['old_pwd'], $user->password)) {
            throw new HandleException(__('账户旧密码错误'));
        }

        return $user;
    }

    /**
     * 创建密码
     *
     * @param string $password
     *
     * @return string
     */
    protected function createPassword(string $password): string
    {
        return $this->hash->password($password);
    }

    /**
     * 校验旧密码
     *
     * @param string $password
     * @param string $hash
     *
     * @return bool
     */
    protected function verifyPassword(string $password, string $hash): bool
    {
        return $this->hash->verify($password, $hash);
    }

    /**
     * 保存.
     *
     * @param array $input
     *
     * @return \Common\Domain\Entity\User\User
     */
    protected function save(array $input): User
    {
        $this->w->persist($entity = $this->entity($input));

        $this->w->flush();

        return $entity;
    }

    /**
     * 验证参数.
     *
     * @param array $input
     *
     * @return \Common\Domain\Entity\User\User
     */
    protected function entity(array $input): User
    {
        $entity = $this->find((int) $input['id']);

        $entity->withProps($this->data($input));

        return $entity;
    }

    /**
     * 查找实体.
     *
     * @param int $id
     *
     * @return \Common\Domain\Entity\User\User
     */
    protected function find(int $id): User
    {
        return $this->w
            ->repository(User::class)
            ->findOrFail($id);
    }

    /**
     * 组装实体数据.
     *
     * @param array $input
     *
     * @return array
     */
    protected function data(array $input): array
    {
        return [
            'password'       => $this->createPassword(trim($input['new_pwd'])),
        ];
    }

    /**
     * 校验基本参数.
     */
    protected function validateArgs()
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
            throw new HandleException(json_encode($validator->error()));
        }
    }
}
