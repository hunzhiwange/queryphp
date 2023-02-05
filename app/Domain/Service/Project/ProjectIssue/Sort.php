<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectIssue;

use App\Domain\Entity\Project\ProjectIssue;
use App\Exceptions\ProjectBusinessException;
use App\Exceptions\ProjectErrorCode;
use Leevel\Database\Condition;
use Leevel\Database\Ddd\UnitOfWork;

/**
 * 任务排序.
 */
class Sort
{
    public function __construct(private UnitOfWork $w)
    {
    }

    public function handle(SortParams $params): array
    {
        $params->validate();
        $this->sort($params);

        return [];
    }

    /**
     * @throws \App\Exceptions\ProjectBusinessException
     */
    public function sort(SortParams $params): void
    {
        $issueRepository = ProjectIssue::repository();
        $preIssue = $issueRepository->findOrFail($params->prevIssueId, ['sort', 'id', 'project_label_id']);

        if ($params->nextIssueId) {
            $nextIssue = $issueRepository->findOrFail($params->nextIssueId, ['sort', 'id', 'project_label_id']);
            if ($nextIssue->projectLabelId !== $params->projectLabelId) {
                throw new ProjectBusinessException(ProjectErrorCode::PROJECT_ISSUE_TASK_LABEL_MUST_BE_THE_SAME_AS_THE_SUBMITTED_LABEL);
            }

            $nextPreIssue = $issueRepository
                ->where('project_id', $params->projectId)
                ->where('project_label_id', $params->projectLabelId)
                ->where('id', '<>', $params->nextIssueId)
                ->where('id', '<>', $params->prevIssueId)
                ->where('sort', '>', $nextIssue->sort)
                ->orderBy('sort DESC')
                ->findEntity()
            ;

            if ($nextPreIssue->id) {
                $newSort = (int) (($nextIssue->sort + $nextPreIssue->sort) / 2);
            } else {
                $maxSort = $issueRepository
                    ->where('project_id', $params->projectId)
                    ->findMax('sort')
                ;
                $newSort = $maxSort + ProjectIssue::SORT_INTERVAL;
            }
        } else {
            $minSort = $issueRepository
                ->where('project_id', $params->projectId)
                ->findMin('sort')
            ;
            $newSort = (int) (($minSort + 0) / 2);
        }

        if ($newSort && $newSort > 50) {
            if ($preIssue->projectLabelId !== $params->projectLabelId) {
                $preIssue->projectLabelId = $params->projectLabelId;
            }

            $preIssue->sort = $newSort;
            $this->w->persist($preIssue);
            $this->w->flush();
        } else {
            // 小于安全值
            $this->resetSort($params->projectId);
            $this->sort($params);
        }
    }

    public function resetSort(int $projectId): void
    {
        $w = clone $this->w;
        $w->persist(function () use ($projectId): void {
            $issueRepository = ProjectIssue::repository();
            $issueRepository->execute('SET @num=1');
            $issueRepository
                ->where('project_id', $projectId)
                ->orderBy('sort ASC,id ASC')
                ->update(['sort' => Condition::raw(sprintf('@num := @num + %d', ProjectIssue::SORT_INTERVAL))])
            ;
        });
        $w->flush();
    }
}
