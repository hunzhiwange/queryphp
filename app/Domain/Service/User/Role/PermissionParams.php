<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Role;

use Leevel\Support\Dto;
use Leevel\Support\TypedIntArray;

/**
 * 角色授权参数.
 */
class PermissionParams extends Dto
{
    public int $id = 0;

    public ?TypedIntArray $permissionId = null;

    protected function permissionIdDefaultValue(): TypedIntArray
    {
        return new TypedIntArray([]);
    }

    protected function permissionIdTransformValue(string|array $value): TypedIntArray
    {
        return TypedIntArray::fromRequest($value);
    }
}
