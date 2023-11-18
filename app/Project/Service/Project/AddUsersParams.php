<?php

declare(strict_types=1);

namespace App\Project\Service\Project;

use Leevel\Support\Dto;
use Leevel\Support\VectorInt;

/**
 * 项目新增成员参数.
 */
class AddUsersParams extends Dto
{
    public int $projectId = 0;

    public ?VectorInt $userIds = null;

    protected function userIdsDefaultValue(): VectorInt
    {
        return new VectorInt([]);
    }

    protected function userIdsTransformValue(string|array $value): VectorInt
    {
        return VectorInt::fromRequest($value);
    }
}
