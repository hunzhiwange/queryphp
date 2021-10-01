<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectIssue;

use App\Domain\Entity\Project\ProjectIssue;
use App\Domain\Entity\Project\ProjectLabel;
use App\Domain\Validate\Project\ProjectLabel as ProjectProjectRelease;
use App\Exceptions\ProjectBusinessException;
use App\Exceptions\ProjectErrorCode;
use Leevel\Database\Ddd\UnitOfWork;
use App\Domain\Validate\Validate;
use Leevel\Database\Condition;
use Leevel\Validate\UniqueRule;

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
        $this->sort($params);

        return [];
    }

    public function sort(SortParams $params): void
    {
        if ($params->prevIssueId === $params->nextIssueId) {
            throw new \Exception('xx');
        }

        $issueRepository = ProjectIssue::repository();
        $preIssue = $issueRepository->findOrFail($params->prevIssueId, ['sort', 'id', 'project_label_id']);

        if ($params->nextIssueId) {
            $nextIssue = $issueRepository->findOrFail($params->nextIssueId, ['sort', 'id', 'project_label_id']);
            if ($nextIssue->projectLabelId !== $params->projectLabelId) {
                throw new \Exception('yyy');
            }

            $nextPreIssue = $issueRepository
                ->where('project_id', $params->projectId)
                ->where('project_label_id', $params->projectLabelId)
                ->where('id', '<>', $params->nextIssueId)
                ->where('id', '<>', $params->prevIssueId)
                ->where('sort', '>', $nextIssue->sort)
                ->orderBy('sort DESC')
                ->findEntity();

            if ($nextPreIssue->id) {
                $newSort = (int) (($nextIssue->sort + $nextPreIssue->sort) / 2);
            } else {
                $maxSort = $issueRepository
                    ->where('project_id', $params->projectId)
                    ->findMax('sort');
                $newSort = $maxSort + 65536;
            }
        }else {
            $minSort = $issueRepository
            ->where('project_id', $params->projectId)
             ->findMin('sort');
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
            //小于安全值
            $this->resetSort($params->projectId);
            $this->sort($params);
        }
    }

    public function resetSort(int $projectId): void
    {
        $w = clone $this->w;
        $w->persist(function() use ($projectId) {
            $issueRepository = ProjectIssue::repository();
            $issueRepository->execute('SET @num=1');
            $issueRepository
                ->where('project_id', $projectId)
                ->orderBy('sort ASC,id ASC')
                ->update(['sort' => Condition::raw('@num := @num + 65536')]);
        });
        $w->flush();
    }

    /**
     * 保存.
     */
    private function save(SortParams $params): ProjectRelease
    {
        $this->w
            ->persist($entity = $this->entity($params))
            ->flush();
        $entity->refresh();

        return $entity;
    }

    /**
     * 创建实体.
     */
    private function entity(SortParams $params): ProjectRelease
    {
        return new ProjectRelease($this->data($params));
    }

    /**
     * 组装实体数据.
     */
    private function data(SortParams $params): array
    {
        return $params->toArray();
    }

    /**
     * 校验基本参数.
     *
     * @throws \App\Exceptions\ProjectBusinessException
     */
    private function validateArgs(SortParams $params): void
    {
        $uniqueRule = UniqueRule::rule(
            ProjectRelease::class,
            additional:[]
        );

        $validator = Validate::make(new ProjectProjectRelease($uniqueRule), 'store', $params->toArray())->getValidator();
        if ($validator->fail()) {
            $e = json_encode($validator->error(), JSON_UNESCAPED_UNICODE);

            throw new ProjectBusinessException(ProjectErrorCode::PROJECT_RELEASE_STORE_INVALID_ARGUMENT, $e, true);
        }
    }
}
