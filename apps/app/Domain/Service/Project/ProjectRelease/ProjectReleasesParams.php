<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectRelease;

use App\Domain\Service\Support\ReadParams;
use Leevel\Collection\TypedIntArray;
use Leevel\Collection\TypedStringArray;

/**
 * 项目版本列表参数.
 */
class ProjectReleasesParams extends ReadParams
{
    public ?int $status = null;

    public string $orderBy = 'sort ASC,id DESC';

    public ?TypedIntArray $projectIds = null;

    protected function columnDefaultValue(): TypedStringArray
    {
        return new TypedStringArray(['*']);
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
