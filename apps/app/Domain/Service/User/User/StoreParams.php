<?php

declare(strict_types=1);

namespace App\Domain\Service\User\User;

use App\Domain\Entity\User\User;
use App\Domain\Validate\User\User as UserValidate;
use App\Domain\Service\Support\StoreParams as CommonStoreParams;

/**
 * 用户保存参数.
 */
class StoreParams extends CommonStoreParams
{
    public string $num;

    public int $status;

    public string $name;

    public string $password;

    protected string $validatorClass = UserValidate::class;

    protected string $entityClass = User::class;
}
