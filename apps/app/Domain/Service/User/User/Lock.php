<?php

declare(strict_types=1);

namespace App\Domain\Service\User\User;

use App\Infra\Lock as CacheLock;

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
        $params->validate();
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
}
