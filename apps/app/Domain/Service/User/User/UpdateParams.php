<?php

declare(strict_types=1);

namespace App\Domain\Service\User\User;

use App\Domain\Entity\User\User;
use App\Domain\Validate\User\User as UserValidate;
use App\Domain\Validate\ValidateParams;
use Leevel\Support\Dto;
use Leevel\Validate\UniqueRule;

/**
 * 用户更新参数.
 */
class UpdateParams extends Dto
{
    use ValidateParams;

    public int $id;

    public ?string $num = null;

    public ?int $status = null;

    public ?string $password = null;

    public ?string $email = null;

    public ?string $mobile = null;

    /**
     * 校验基本参数.
     */
    public function validate(): void
    {
        $uniqueRule = UniqueRule::rule(
            User::class,
            exceptId:$this->id,
        );

        $this->baseValidate(
            new UserValidate($uniqueRule),
            'update',
        );
    }
}
