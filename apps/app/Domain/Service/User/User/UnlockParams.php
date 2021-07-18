<?php

declare(strict_types=1);

namespace App\Domain\Service\User\User;

use Leevel\Support\Dto;

/**
 * 解锁管理面板参数.
 */
class UnlockParams extends Dto
{
    public int $id;

    public string $token;

    public string $password;
}
