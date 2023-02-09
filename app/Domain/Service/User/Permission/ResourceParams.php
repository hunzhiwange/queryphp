<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Permission;

use Leevel\Support\Dto;
use Leevel\Support\TypedIntArray;

/**
 * 权限资源授权参数.
 */
class ResourceParams extends Dto
{
    public int $id = 0;

    public ?TypedIntArray $resourceId = null;

    protected function resourceIdDefaultValue(): TypedIntArray
    {
        return new TypedIntArray([]);
    }

    protected function resourceIdTransformValue(string|array $value): TypedIntArray
    {
        return TypedIntArray::fromRequest($value);
    }
}
