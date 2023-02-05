<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectIssue;

use App\Domain\Entity\Project\Project;
use App\Domain\Entity\Project\ProjectContent;
use App\Domain\Entity\Project\ProjectIssue;
use Leevel\Database\Ddd\UnitOfWork;

/**
 * 项目问题保存.
 */
class Store
{
    private ?Project $project = null;

    public function __construct(private UnitOfWork $w)
    {
    }

    public function handle(StoreParams $params): array
    {
        $params->validate();
        $this->project = Project::repository()->findOrFail($params->projectId);

        return $this->save($params)->toArray();
    }

    /**
     * 保存.
     */
    private function save(StoreParams $params): ProjectIssue
    {
        $this->w->persist($entity = $this->entity($params));
        $this->w->on($entity, function (ProjectIssue $entity): void {
            $projectContentEntity = new ProjectContent([
                'project_id' => $entity->projectId,
                'project_issue_id' => $entity->id,
                'content' => '',
            ]);
            $this->w->persist($projectContentEntity);
        });

        $this->w->flush();
        $entity->refresh();

        return $entity;
    }

    /**
     * 创建实体.
     */
    private function entity(StoreParams $params): ProjectIssue
    {
        $entity = new ProjectIssue($this->data($params));
        $maxId = ProjectIssue::repository()->findNextIssueNum($params->projectId);
        $entity->num = strtoupper($this->project->num).'-'.$maxId;

        return $entity;
    }

    /**
     * 组装实体数据.
     */
    private function data(StoreParams $params): array
    {
        $maxSort = ProjectIssue::repository()
            ->where('project_id', $params->projectId)
            ->findMax('sort')
        ;
        $newSort = $maxSort + ProjectIssue::SORT_INTERVAL;

        $data = $params->toArray();
        $data['sort'] = $newSort;

        return $data;
    }
}
