<?php

declare(strict_types=1);

namespace App\User\Service\User;

use Leevel\Support\Dto;
use Leevel\Support\VectorInt;

/**
 * 用户授权角色参数.
 */
class RoleParams extends Dto
{
    public int $id = 0;

    public ?VectorInt $roleId = null;

    protected function roleIdDefaultValue(): VectorInt
    {
        return new VectorInt([]);
    }

    protected function roleIdTransformValue(string|array $value): VectorInt
    {
        return VectorInt::fromRequest($value);
    }
}
