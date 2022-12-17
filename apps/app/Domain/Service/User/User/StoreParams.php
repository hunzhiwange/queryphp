<?php

declare(strict_types=1);

namespace App\Domain\Service\User\User;

use App\Domain\Entity\User\User;
use App\Domain\Validate\User\User as UserValidate;
use App\Domain\Validate\ValidateParams;
use Leevel\Support\Dto;
use Leevel\Validate\UniqueRule;

/**
 * 用户保存参数.
 */
class StoreParams extends Dto
{
    use ValidateParams;

    public string $num;

    public int $status;

    public string $name;

    public string $password;

    /**
     * 校验基本参数.
     */
    public function validate(): void
    {
        $uniqueRule = UniqueRule::rule(
            User::class,
        );

        $this->baseValidate(
            new UserValidate($uniqueRule),
            'store',
        );
    }
}
