<?php

declare(strict_types=1);

namespace App\Domain\Service\User\User;

use Leevel\Collection\TypedIntArray;
use Leevel\Support\Dto;

/**
 * 用户保存参数.
 */
class StoreParams extends Dto
{
    public string $name;

    public string $num;

    public int $status;

    public string $password;
    
    public TypedIntArray $userRole;
}
