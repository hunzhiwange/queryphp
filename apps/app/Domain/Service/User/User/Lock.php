<?php

declare(strict_types=1);

namespace App\Domain\Service\User\User;

use App\Infra\Lock as CacheLock;
use App\Exceptions\UserBusinessException;
use App\Exceptions\UserErrorCode;
use Leevel\Validate\Proxy\Validate as Validates;

/**
 * 锁定管理面板.
 */
class Lock
{
    public function __construct(private CacheLock $lock)
    {
    }

    public function handle(LockParams $params): array
    {
        $this->validateArgs($params);
        $this->lock($params->token);

        return [];
    }

    /**
     * 锁定.
     */
    private function lock(string $token): void
    {
        $this->lock->set($token);
    }

    /**
     * 校验基本参数.
     *
     * @throws \App\Exceptions\UserBusinessException
     */
    private function validateArgs(LockParams $params): void
    {
        $validator = Validates::make(
            $params->toArray(),
            [
                'token'  => 'required',
            ],
            [
                'token' => 'Token',
            ]
        );

        if ($validator->fail()) {
            $e = json_encode($validator->error(), JSON_UNESCAPED_UNICODE);

            throw new UserBusinessException(UserErrorCode::LOCK_ANAGEMENT_PANEL_INVALID_ARGUMENT, $e, true);
        }
    }
}
