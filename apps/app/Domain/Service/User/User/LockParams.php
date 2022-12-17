<?php

declare(strict_types=1);

namespace App\Domain\Service\User\User;

use App\Domain\Validate\User\User as UserValidate;
use App\Domain\Validate\ValidateParams;
use Leevel\Support\Dto;

/**
 * 锁定管理面板参数.
 */
class LockParams extends Dto
{
    use ValidateParams;

    public string $token;

    /**
     * 校验基本参数.
     */
    public function validate(): void
    {
        $this->baseValidate(
            new UserValidate(),
            'lock',
        );
    }
}
