<?php

declare(strict_types=1);

namespace App\Domain\Service\User\User;

use Leevel\Collection\TypedIntArray;
use Leevel\Support\Dto;

/**
 * 用户更新参数.
 */
class UpdateParams extends Dto
{
    public int $id;

    public string $num;

    public int $status;
    
    public string $password = '';
    
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
