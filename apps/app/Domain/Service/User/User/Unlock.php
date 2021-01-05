<?php

declare(strict_types=1);

namespace App\Domain\Service\User\User;

use Admin\Infra\Lock;
use App\Domain\Entity\User\User;
use App\Exceptions\UserBusinessException;
use App\Exceptions\UserErrorCode;
use Leevel\Database\Ddd\UnitOfWork;
use Leevel\Validate\Proxy\Validate as Validates;
use App\Infra\Repository\User\User as UserReposity;

/**
 * 解锁.
 */
class Unlock
{
    private array $input;

    public function __construct(private UnitOfWork $w, private Lock $lock)
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
     */
    private function validateUser(): void 
    {
        $userReposity = $this->userReposity();
        $user = $userReposity->findValidUserById($this->input['id'], 'id,password');
        $userReposity->verifyPassword($this->input['password'], $user->password);
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

            throw new UserBusinessException(UserErrorCode::UNLOCK_ANAGEMENT_PANEL_INVALID_ARGUMENT, $e, true);
        }
    }
}
