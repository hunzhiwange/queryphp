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
            // 下一条任务编号需要查询软删除的数据，避免编号重复
            ->withSoftDeleted()
            ->where('project_id', $projectId)
            ->columns('num')
            ->orderBy('id DESC')
            ->findOne()
        ;
        if (!$projectIssue->num) {
            return 1;
        }

        return (int) explode('-', $projectIssue->num)[1] + 1;
    }
}
