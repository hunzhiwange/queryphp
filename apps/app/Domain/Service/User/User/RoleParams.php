<?php

declare(strict_types=1);

namespace App\Domain\Service\User\User;

use Leevel\Collection\TypedIntArray;
use Leevel\Support\Dto;

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
