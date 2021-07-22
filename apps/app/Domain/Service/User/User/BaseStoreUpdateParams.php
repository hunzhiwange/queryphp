<?php

declare(strict_types=1);

namespace App\Domain\Service\User\User;

use Leevel\Collection\TypedIntArray;

trait BaseStoreUpdateParams
{
    public string $num;

    public int $status;
    
    public TypedIntArray $userRole;

    protected function userRoleDefaultValue(): TypedIntArray
    {
        return new TypedIntArray([]);
    }

    protected function userRoleTransformValue(string|array $value): TypedIntArray
    {
        return TypedIntArray::fromRequest($value);
    }
}
