<?php

declare(strict_types=1);

namespace App\Project\Service\ProjectIssue;

use Leevel\Support\Dto;
use Leevel\Support\VectorInt;

/**
 * 项目任务更新参数.
 */
class UpdateParams extends Dto
{
    public int $id = 0;

    public ?string $title = null;

    public ?VectorInt $tags = null;

    public ?VectorInt $modules = null;

    public ?VectorInt $releases = null;

    public ?int $completed = null;

    public ?string $completedDate = null;

    public ?string $content = null;

    public ?string $subTitle = null;

    protected function tagsTransformValue(string|array $value): VectorInt
    {
        return VectorInt::fromRequest($value);
    }

    protected function modulesTransformValue(string|array $value): VectorInt
    {
        return VectorInt::fromRequest($value);
    }

    protected function releasesTransformValue(string|array $value): VectorInt
    {
        return VectorInt::fromRequest($value);
    }
}
