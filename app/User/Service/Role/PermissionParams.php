<?php

declare(strict_types=1);

namespace App\User\Service\Role;

use Leevel\Support\Dto;
use Leevel\Support\VectorInt;

/**
 * 角色授权参数.
 */
class PermissionParams extends Dto
{
    public int $id = 0;

    public ?VectorInt $permissionId = null;

    protected function permissionIdDefaultValue(): VectorInt
    {
        return new VectorInt([]);
    }

    protected function permissionIdTransformValue(string|array $value): VectorInt
    {
        return VectorInt::fromRequest($value);
    }
}
