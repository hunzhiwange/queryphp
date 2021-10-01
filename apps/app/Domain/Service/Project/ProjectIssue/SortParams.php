<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectIssue;

use Leevel\Support\Dto;

/**
 * 任务排序参数.
 */
class SortParams extends Dto
{
    public int $projectId;

    public int $prevIssueId;

    public ?int $nextIssueId = null;

    public int $projectLabelId;
}
