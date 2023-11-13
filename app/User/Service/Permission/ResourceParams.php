<?php

declare(strict_types=1);

namespace App\User\Service\Permission;

use Leevel\Support\Dto;
use Leevel\Support\VectorInt;

/**
 * 权限资源授权参数.
 */
class ResourceParams extends Dto
{
    public int $id = 0;

    public ?VectorInt $resourceId = null;

    protected function resourceIdDefaultValue(): VectorInt
    {
        return new VectorInt([]);
    }

    protected function resourceIdTransformValue(string|array $value): VectorInt
    {
        return VectorInt::fromRequest($value);
    }
}
