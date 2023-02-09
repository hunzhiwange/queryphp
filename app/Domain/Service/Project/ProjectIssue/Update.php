<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectIssue;

use App\Domain\Entity\Project\ProjectContent;
use App\Domain\Entity\Project\ProjectIssue;
use App\Domain\Entity\Project\ProjectIssueCompletedEnum;
use App\Domain\Entity\Project\ProjectIssueModule;
use App\Domain\Entity\Project\ProjectIssueRelease;
use App\Domain\Entity\Project\ProjectIssueTag;
use App\Exceptions\ProjectBusinessException;
use Leevel\Database\Ddd\Select;
use Leevel\Database\Ddd\UnitOfWork;

/**
 * 项目任务更新.
 */
class Update
{
    public function __construct(private UnitOfWork $w)
    {
    }

    public function handle(UpdateParams $params): array
    {
        if (isset($params->tags)) {
            $this->tags($params);
        }

        if (isset($params->releases)) {
            $this->releases($params);
        }

        if (isset($params->modules)) {
            $this->modules($params);
        }

        if (isset($params->content)) {
            $this->saveContent($params);
        }

        if (isset($params->completed)
            && ProjectIssueCompletedEnum::TRUE->value === $params->completed
            && !isset($params->completedDate)) {
            $params->completedDate = get_current_date();
        }

        return $this->save($params)->toArray();
    }

    /**
     * @throws \Exception|ProjectBusinessException
     */
    private function saveContent(UpdateParams $params): void
    {
        $projectContent = $this->w
            ->repository(ProjectContent::class)
            ->where('project_issue_id', $params->id)
            ->findOne()
        ;
        if (!$projectContent->id) {
            throw new ProjectBusinessException(0, 'xx');
        }
        $projectContent->content = $params->content;
        $this->w->update($projectContent);
    }

    private function tags(UpdateParams $params): void
    {
        $this->w->persist(function () use ($params): void {
            $old = $this->w
                ->repository(ProjectIssueTag::class)
                ->findAll(function (Select $select) use ($params): void {
                    $select->where('project_issue_id', $params->id);
                })
            ;
            $oldIds = array_column($old->toArray(), 'id', 'project_tag_id');
            $old = array_column($old->toArray(), 'project_tag_id');
            $now = $params->tags->toArray();
            $del = array_diff($old, $now);
            $updateData = [];
            foreach ($params->tags as $projectTagId) {
                if (\in_array($projectTagId, $old, true)) {
                    $updateData[] = [
                        'id' => $oldIds[$projectTagId],
                        'project_issue_id' => $params->id,
                        'project_tag_id' => $projectTagId,
                        'delete_at' => 0,
                    ];
                } else {
                    $updateData[] = [
                        'id' => 0,
                        'project_issue_id' => $params->id,
                        'project_tag_id' => $projectTagId,
                        'delete_at' => 0,
                    ];
                }
            }
            foreach ($del as $id) {
                $updateData[] = [
                    'id' => $oldIds[$id],
                    'project_issue_id' => $params->id,
                    'project_tag_id' => $id,
                    'delete_at' => time(),
                ];
            }
            ProjectIssueTag::repository()->insertAll($updateData, replace: ['delete_at']);
        });
    }

    private function releases(UpdateParams $params): void
    {
        $this->w->persist(function () use ($params): void {
            $old = $this->w
                ->repository(ProjectIssueRelease::class)
                ->findAll(function (Select $select) use ($params): void {
                    $select->where('project_issue_id', $params->id);
                })
            ;
            $oldIds = array_column($old->toArray(), 'id', 'project_release_id');
            $old = array_column($old->toArray(), 'project_release_id');
            $now = $params->releases->toArray();
            $del = array_diff($old, $now);
            $updateData = [];
            foreach ($params->releases as $projectReleaseId) {
                if (\in_array($projectReleaseId, $old, true)) {
                    $updateData[] = [
                        'id' => $oldIds[$projectReleaseId],
                        'project_issue_id' => $params->id,
                        'project_release_id' => $projectReleaseId,
                        'delete_at' => 0,
                    ];
                } else {
                    $updateData[] = [
                        'id' => 0,
                        'project_issue_id' => $params->id,
                        'project_release_id' => $projectReleaseId,
                        'delete_at' => 0,
                    ];
                }
            }
            foreach ($del as $id) {
                $updateData[] = [
                    'id' => $oldIds[$id],
                    'project_issue_id' => $params->id,
                    'project_release_id' => $id,
                    'delete_at' => time(),
                ];
            }
            ProjectIssueRelease::repository()->insertAll($updateData, replace: ['delete_at']);
        });
    }

    private function modules(UpdateParams $params): void
    {
        $this->w->persist(function () use ($params): void {
            $old = $this->w
                ->repository(ProjectIssueModule::class)
                ->findAll(function (Select $select) use ($params): void {
                    $select->where('project_issue_id', $params->id);
                })
            ;
            $oldIds = array_column($old->toArray(), 'id', 'project_module_id');
            $old = array_column($old->toArray(), 'project_module_id');
            $now = $params->modules->toArray();
            $del = array_diff($old, $now);
            $updateData = [];
            foreach ($params->modules as $projectModuleId) {
                if (\in_array($projectModuleId, $old, true)) {
                    $updateData[] = [
                        'id' => $oldIds[$projectModuleId],
                        'project_issue_id' => $params->id,
                        'project_module_id' => $projectModuleId,
                        'delete_at' => 0,
                    ];
                } else {
                    $updateData[] = [
                        'id' => 0,
                        'project_issue_id' => $params->id,
                        'project_module_id' => $projectModuleId,
                        'delete_at' => 0,
                    ];
                }
            }
            foreach ($del as $id) {
                $updateData[] = [
                    'id' => $oldIds[$id],
                    'project_issue_id' => $params->id,
                    'project_module_id' => $id,
                    'delete_at' => time(),
                ];
            }
            ProjectIssueModule::repository()->insertAll($updateData, replace: ['delete_at']);
        });
    }

    /**
     * 保存.
     */
    private function save(UpdateParams $params): ProjectIssue
    {
        $this->w
            ->persist($entity = $this->entity($params))
            ->flush()
        ;
        $entity->refresh();

        return $entity;
    }

    /**
     * 验证参数.
     */
    private function entity(UpdateParams $params): ProjectIssue
    {
        $entity = $this->find($params->id);
        $entity->withProps($this->data($params));

        return $entity;
    }

    /**
     * 查找实体.
     */
    private function find(int $id): ProjectIssue
    {
        return $this->w
            ->repository(ProjectIssue::class)
            ->findOrFail($id)
        ;
    }

    /**
     * 组装实体数据.
     */
    private function data(UpdateParams $params): array
    {
        return $params
            ->except([
                'id',
                'tags',
                'releases',
                'modules',
                'content',
            ])
            ->withoutNull()
            ->toArray()
        ;
    }
}
