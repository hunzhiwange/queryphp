<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Permission;

use Leevel\Support\TypedIntArray;
use Leevel\Support\Dto;

/**
 * 权限资源授权参数.
 */
class ResourceParams extends Dto
{
    public int $id;

    public TypedIntArray $resourceId;

    protected function resourceIdDefaultValue(): TypedIntArray
    {
        return new TypedIntArray([]);
    }

    protected function resourceIdTransformValue(string|array $value): TypedIntArray
    {
        return TypedIntArray::fromRequest($value);
    }
}
