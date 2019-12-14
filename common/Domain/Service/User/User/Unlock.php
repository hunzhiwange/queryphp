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

use Admin\Infra\Lock;
use Common\Domain\Entity\User\User;
use Common\Infra\Exception\BusinessException;
use Leevel\Auth\Hash;
use Leevel\Database\Ddd\IUnitOfWork;
use Leevel\Validate\Proxy\Validate as Validates;

/**
 * 解锁.
 */
class Unlock
{
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
    private IUnitOfWork $w;

    /**
     * 构造函数.
     */
    public function __construct(IUnitOfWork $w, Hash $hash, Lock $lock)
    {
        $this->w = $w;
        $this->hash = $hash;
        $this->lock = $lock;
    }

    /**
     * 响应方法.
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
     * @throws \Common\Infra\Exception\BusinessException
     */
    protected function validateUser(): User
    {
        $user = User::Where('status', '1')
            ->where('id', $this->input['id'])
            ->findOne();

        if (!$user->id) {
            throw new BusinessException(__('账号不存在或者已禁用'));
        }

        if (!$this->verifyPassword($this->input['password'], $user->password)) {
            throw new BusinessException(__('解锁密码错误'));
        }

        return $user;
    }

    /**
     * 对比验证码
     */
    protected function verifyPassword(string $password, string $hash): bool
    {
        return $this->hash->verify($password, $hash);
    }

    /**
     * 校验基本参数.
     *
     * @throws \Common\Infra\Exception\BusinessException
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
            throw new BusinessException(json_encode($validator->error()));
        }
    }
}
