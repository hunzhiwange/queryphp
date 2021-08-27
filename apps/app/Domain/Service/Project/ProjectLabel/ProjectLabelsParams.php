<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectLabel;

use App\Domain\Service\Support\ReadParams;
use Leevel\Collection\TypedIntArray;
use Leevel\Collection\TypedStringArray;

/**
 * 项目分类列表参数.
 */
class ProjectLabelsParams extends ReadParams
{
    public ?TypedIntArray $projectIds = null;

    public string $orderBy = 'sort ASC,id DESC';

    protected function columnDefaultValue(): TypedStringArray
    {
        return new TypedStringArray([
            '*'
        ]);
    }

    protected function keyColumnDefaultValue(): TypedStringArray
    {
        return new TypedStringArray([
            'id', 'name',
        ]);
    }

    protected function projectIdsTransformValue(string|array $value): TypedIntArray
    {
        return TypedIntArray::fromRequest($value);
    }
}
