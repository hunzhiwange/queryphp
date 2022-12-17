<?php

declare(strict_types=1);

namespace App\Domain\Service\User\User;

use App\Domain\Dto\ParamsDto;
use App\Domain\Entity\User\User;
use App\Domain\Validate\User\User as UserValidate;
use Leevel\Validate\UniqueRule;

/**
 * 用户保存参数.
 */
class StoreParams extends ParamsDto
{

    public string $num;

    public int $status;

    public string $name;

    public string $password;

    protected string $validatorClass = UserValidate::class;

    protected string $validatorScene = 'store';

    /**
     * {@inheritDoc}
     */
    protected function validatorClassArgs(): array
    {
        $uniqueRule = UniqueRule::rule(
            User::class,
        );

        return [$uniqueRule];
    }
}
