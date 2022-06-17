<?php

declare(strict_types=1);

namespace App\Infra\Repository\Project;

use Leevel\Database\Ddd\Repository;

/**
 * 项目任务仓储.
 */
class ProjectIssue extends Repository
{
    /**
     * 查找下一条任务编号.
     */
    public function findNextIssueNum(int $projectId): int
    {
        $projectIssue = $this->entity
            ->select()
            ->where('project_id', $projectId)
            ->columns('num')
            ->orderBy('id DESC')
            ->findOne();
        if (!$projectIssue->num) {
            return 1;
        }

        return (int) explode('-', $projectIssue->num)[1] + 1;
    }
}
