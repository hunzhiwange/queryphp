<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectIssue;

use App\Domain\Service\Support\ReadParams;
use Leevel\Collection\TypedIntArray;
use Leevel\Collection\TypedStringArray;

/**
 * 项目问题列表参数.
 */
class ProjectIssuesParams extends ReadParams
{
    public ?int $userId = null;

    public ?string $type = null;

    public ?TypedIntArray $projectIds = null;

    public string $orderBy = 'completed ASC,sort ASC,id DESC';

    protected function columnDefaultValue(): TypedStringArray
    {
        return new TypedStringArray([
            '*'
        ]);
    }

    protected function keyColumnDefaultValue(): TypedStringArray
    {
        return new TypedStringArray([
            'id', 'title',
        ]);
    }

    protected function projectIdsTransformValue(string|array $value): TypedIntArray
    {
        return TypedIntArray::fromRequest($value);
    }
}
