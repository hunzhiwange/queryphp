<?php

declare(strict_types=1);

namespace App\Domain\Service\User\User;

use Leevel\Support\Dto;

/**
 * 锁定管理面板参数.
 */
class LockParams extends Dto
{
    public string $token;
}
