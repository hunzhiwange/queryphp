<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectLabel;

use Leevel\Support\TypedIntArray;
use Leevel\Support\Dto;

/**
 * 项目分类排序参数.
 */
class SortParams extends Dto
{
    public int $projectId;

    public TypedIntArray $projectLabelIds;

    protected function projectLabelIdsTransformValue(string|array $value): TypedIntArray
    {
        return TypedIntArray::fromRequest($value);
    }
}
