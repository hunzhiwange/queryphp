<?php

declare(strict_types=1);

namespace App\Domain\Service\User\User;

use Admin\Infra\Lock;
use App\Domain\Entity\User\User;
use App\Exceptions\BusinessException;
use Leevel\Auth\Hash;
use Leevel\Database\Ddd\UnitOfWork;
use Leevel\Validate\Proxy\Validate as Validates;

/**
 * 解锁.
 */
class Unlock
{
    private array $input;

    public function __construct(private UnitOfWork $w, private Hash $hash, private Lock $lock)
    {
        $this->lock = $lock;
    }

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
    private function unlock(): void
    {
        $this->lock->delete($this->input['token']);
    }

    /**
     * 校验用户.
     *
     * @throws \App\Exceptions\BusinessException
     */
    private function validateUser(): User
    {
        $user = User::select()
            ->where('status', 1)
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
    private function verifyPassword(string $password, string $hash): bool
    {
        return $this->hash->verify($password, $hash);
    }

    /**
     * 校验基本参数.
     *
     * @throws \App\Exceptions\BusinessException
     */
    private function validateArgs(): void
    {
        $validator = Validates::make(
            $this->input,
            [
                'id'                   => 'required',
                'token'                => 'required',
                'password' => 'required|alpha_dash|min_length:6',
            ],
            [
                'id'                   => 'ID',
                'token'                => 'Token',
                'password' => __('解锁密码'),
            ]
        );

        if ($validator->fail()) {
            $e = json_encode($validator->error(), JSON_UNESCAPED_UNICODE);

            throw new BusinessException($e);
        }
    }
}
