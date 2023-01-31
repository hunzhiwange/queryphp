<?php

declare(strict_types=1);

namespace App\Domain\Service\User\User;

use App\Domain\Entity\User\User;
use App\Domain\Service\Support\UpdateParams as CommonUpdateParams;
use App\Domain\Validate\User\User as UserValidate;

/**
 * 用户更新参数.
 */
class UpdateParams extends CommonUpdateParams
{
    public int $id;

    public ?string $num = null;

    public ?int $status = null;

    public ?string $password = null;

    public ?string $email = null;

    public ?string $mobile = null;

    protected string $validatorClass = UserValidate::class;

    protected string $entityClass = User::class;
}
