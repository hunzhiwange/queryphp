<?php

declare(strict_types=1);

namespace App\Domain\Service\User\User;

use App\Domain\Validate\User\User as UserValidate;
use App\Domain\Validate\ValidateParams;
use Leevel\Support\Dto;

/**
 * 解锁管理面板参数.
 */
class UnlockParams extends Dto
{
    use ValidateParams;

    public int $id;

    public string $token;

    public string $password;

    /**
     * 校验基本参数.
     */
    public function validate(): void
    {
        $this->baseValidate(
            new UserValidate(),
            'unlock',
        );
    }
}
