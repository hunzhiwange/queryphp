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

namespace Common\Infra\Repository\User\User;

use Admin\Infra\Lock;
use Common\Domain\Entity\User\User;
use Leevel\Auth\Hash;
use Leevel\Database\Ddd\IUnitOfWork;
use Leevel\Kernel\Exception\HandleException;
use Leevel\Validate\Facade\Validate as Validates;

/**
 * 解锁.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.11.21
 *
 * @version 1.0
 */
class Unlock
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
     * 锁定缓存.
     *
     * @var \Admin\Infra\Lock
     */
    protected $lock;

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
     * @param \Admin\Infra\Lock                $lock
     */
    public function __construct(IUnitOfWork $w, Hash $hash, Lock $lock)
    {
        $this->w = $w;
        $this->hash = $hash;
        $this->lock = $lock;
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

        $this->unlock();

        return [];
    }

    /**
     * 解锁.
     */
    protected function unlock()
    {
        $this->lock->delete($this->input['token']);
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

        if (!$this->verifyPassword($this->input['password'], $user->password)) {
            throw new HandleException(__('解锁密码错误'));
        }

        return $user;
    }

    /**
     * 对比验证码
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
     * 校验基本参数.
     */
    protected function validateArgs()
    {
        $validator = Validates::make(
            $this->input,
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
            throw new HandleException(json_encode($validator->error()));
        }
    }
}
