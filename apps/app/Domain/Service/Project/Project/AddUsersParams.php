<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\Project;

use Leevel\Collection\TypedIntArray;
use Leevel\Support\Dto;

/**
 * 项目新增成员参数.
 */
class AddUsersParams extends Dto
{
    public int $projectId;

    public TypedIntArray $userIds;

    protected function userIdsDefaultValue(): TypedIntArray
    {
        return new TypedIntArray([]);
    }

    protected function userIdsTransformValue(string|array $value): TypedIntArray
    {
        return TypedIntArray::fromRequest($value);
    }
}
