<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectIssue;

use Leevel\Support\Dto;
use Leevel\Collection\TypedIntArray;

/**
 * 项目任务更新参数.
 */
class UpdateParams extends Dto
{
    public int $id;

    public ?string $title = null;

    public ?TypedIntArray $tags = null;

    public ?TypedIntArray $modules = null;

    public ?TypedIntArray $releases = null;

    public ?int $completed = null;

    public ?string $completedDate = null;

    protected function tagsTransformValue(string|array $value): TypedIntArray
    {
        return TypedIntArray::fromRequest($value);
    }

    protected function modulesTransformValue(string|array $value): TypedIntArray
    {
        return TypedIntArray::fromRequest($value);
    }

    protected function releasesTransformValue(string|array $value): TypedIntArray
    {
        return TypedIntArray::fromRequest($value);
    }
}
