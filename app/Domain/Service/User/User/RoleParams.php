<?php

declare(strict_types=1);

namespace App\Domain\Service\User\User;

use Leevel\Support\Dto;
use Leevel\Support\TypedIntArray;

/**
 * 用户授权角色参数.
 */
class RoleParams extends Dto
{
    public int $id;

    public TypedIntArray $roleId;

    protected function roleIdDefaultValue(): TypedIntArray
    {
        return new TypedIntArray([]);
    }

    protected function roleIdTransformValue(string|array $value): TypedIntArray
    {
        return TypedIntArray::fromRequest($value);
    }
}
