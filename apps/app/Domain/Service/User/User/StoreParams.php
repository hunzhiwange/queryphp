<?php

declare(strict_types=1);

namespace App\Domain\Service\User\User;

use Leevel\Support\Dto;

/**
 * 用户保存参数.
 */
class StoreParams extends Dto
{
    public string $num;

    public int $status;

    public string $name;

    public string $password;
}
