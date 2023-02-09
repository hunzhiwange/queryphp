<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectIssue;

use App\Domain\Dto\ParamsDto;
use App\Exceptions\ProjectBusinessException;
use App\Exceptions\ProjectErrorCode;

/**
 * 任务排序参数.
 */
class SortParams extends ParamsDto
{
    public int $projectId = 0;

    public int $prevIssueId = 0;

    public ?int $nextIssueId = null;

    public int $projectLabelId = 0;

    /**
     * {@inheritDoc}
     *
     * @throws \Exception
     * @throws ProjectBusinessException
     */
    protected function beforeValidate(): void
    {
        if ($this->prevIssueId === $this->nextIssueId) {
            throw new ProjectBusinessException(ProjectErrorCode::PROJECT_ISSUE_TASK_ID_CANNOT_BE_THE_SAME_AS_THE_TARGET_TASK_ID);
        }
    }
}
