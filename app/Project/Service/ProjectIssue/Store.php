<?php

declare(strict_types=1);

namespace App\Project\Service\ProjectIssue;

use App\Infra\Service\ApiQL\ApiQLStoreParams;
use App\Project\Entity\Project;
use App\Project\Entity\ProjectContent;
use App\Project\Entity\ProjectIssue;
use Leevel\Database\Ddd\UnitOfWork;
use function inject_snowflake_id;

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
        $data = $this->data($params);
        $data = inject_snowflake_id($data, ProjectIssue::class);
        $data = ApiQLStoreParams::exceptInput($data);
        $entity = new ProjectIssue($data);
        $maxId = ProjectIssue::repository()->findNextIssueNum($params->projectId);
        // @phpstan-ignore-next-line
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
