<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectIssue;

use App\Domain\Entity\Project\Project;
use App\Domain\Entity\Project\ProjectContent;
use App\Domain\Entity\Project\ProjectIssue;
use App\Domain\Validate\Project\ProjectRelease as ProjectProjectRelease;
use App\Domain\Validate\Validate;
use App\Exceptions\ProjectBusinessException;
use App\Exceptions\ProjectErrorCode;
use Leevel\Database\Ddd\UnitOfWork;
use Leevel\Validate\UniqueRule;

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
        // $this->validateArgs($params);

        $this->project = Project::repository()->findOrFail($params->projectId);

        return $this->save($params)->toArray();
    }

    /**
     * 保存.
     */
    private function save(StoreParams $params): ProjectIssue
    {
        $this->w
            ->persist($entity = $this->entity($params));
        $this->w->on($entity, function (ProjectIssue $entity) {
            $updateEntity = new ProjectIssue([
                'id' => $entity->id,
            ], true);
            $updateEntity->num = strtoupper($this->project->num).'-'.$updateEntity->id;
            $this->w->update($updateEntity);
        });

        $this->w->on($entity, function (ProjectIssue $entity) {
            $projectContentEntity = new ProjectContent([
                'project_id'       => $entity->projectId,
                'project_issue_id' => $entity->id,
                'content'          => '',
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
        return new ProjectIssue($this->data($params));
    }

    /**
     * 组装实体数据.
     */
    private function data(StoreParams $params): array
    {
        $maxSort = ProjectIssue::repository()
            ->where('project_id', $params->projectId)
            ->findMax('sort');
        $newSort = $maxSort + ProjectIssue::SORT_INTERVAL;

        $data = $params->toArray();
        $data['sort'] = $newSort;

        return $data;
    }

    /**
     * 校验基本参数.
     *
     * @throws \App\Exceptions\ProjectBusinessException
     */
    private function validateArgs(StoreParams $params): void
    {
        $uniqueRule = UniqueRule::rule(
            ProjectRelease::class,
            additional:['project_id' => $params->projectId]
        );

        $validator = Validate::make(new ProjectProjectRelease($uniqueRule), 'store', $params->toArray())->getValidator();
        if ($validator->fail()) {
            $e = json_encode($validator->error(), JSON_UNESCAPED_UNICODE);

            throw new ProjectBusinessException(ProjectErrorCode::PROJECT_RELEASE_STORE_INVALID_ARGUMENT, $e, true);
        }
    }
}
