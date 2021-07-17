<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Role;

use Leevel\Collection\TypedIntArray;
use Leevel\Support\Dto;

/**
 * 角色授权参数.
 */
class PermissionParams extends Dto
{
    public int $id;

    public TypedIntArray $permissionId;

    protected function permissionIdDefaultValue(): TypedIntArray
    {
        return new TypedIntArray([]);
    }

    protected function permissionIdTransformValue(string|array $value): TypedIntArray
    {
        return TypedIntArray::fromRequest($value);
    }
}
