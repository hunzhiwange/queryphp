<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectIssue;

use Leevel\Support\Dto;
use Leevel\Support\TypedIntArray;

/**
 * 项目任务更新参数.
 */
class UpdateParams extends Dto
{
    public int $id = 0;

    public ?string $title = null;

    public ?TypedIntArray $tags = null;

    public ?TypedIntArray $modules = null;

    public ?TypedIntArray $releases = null;

    public ?int $completed = null;

    public ?string $completedDate = null;

    public ?string $content = null;

    public ?string $subTitle = null;

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
