<?php

declare(strict_types=1);

namespace App\Domain\Service\User\User;

use App\Domain\Entity\User\User;
use App\Domain\Dto\ParamsDto;
use App\Domain\Validate\User\User as UserValidate;
use Leevel\Validate\UniqueRule;

/**
 * 用户更新参数.
 */
class UpdateParams extends ParamsDto
{
    public int $id;

    public ?string $num = null;

    public ?int $status = null;

    public ?string $password = null;

    public ?string $email = null;

    public ?string $mobile = null;

    protected string $validatorClass = UserValidate::class;

    protected string $validatorScene = 'update';

    /**
     * {@inheritDoc}
     */
    protected function validatorClassArgs(): array
    {
        $uniqueRule = UniqueRule::rule(
            User::class,
            exceptId:$this->id,
        );

        return [$uniqueRule];
    }
}
