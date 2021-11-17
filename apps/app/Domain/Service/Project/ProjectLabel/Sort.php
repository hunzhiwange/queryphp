<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectLabel;

use App\Domain\Entity\Project\Project;
use App\Domain\Entity\Project\ProjectLabel;
use App\Domain\Validate\Project\ProjectLabel as ProjectProjectRelease;
use App\Domain\Validate\Validate;
use App\Exceptions\ProjectBusinessException;
use App\Exceptions\ProjectErrorCode;
use Leevel\Database\Ddd\UnitOfWork;
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
        $project = Project::repository()->findOrFail($params->projectId);
        if ($params->projectLabelIds->isEmpty()) {
            throw new \Exception('xx');
        }

        $projectLabelIds = $params->projectLabelIds->toArray();
        if (count($projectLabelIds) !== count(array_unique($projectLabelIds))) {
            throw new \Exception('xxx');
        }

        // 检测是否为所有 label，不是直接报错
        $count = ProjectLabel::repository()
            ->whereIn('id', $projectLabelIds)
            ->findCount();
        if ($count !== count($params->projectLabelIds)) {
            throw new \Exception('yy');
        }

        $this->w->persist(function () use ($projectLabelIds) {
            $updateData = [];
            foreach ($projectLabelIds as $k => $projectLabelId) {
                $updateData[] = [
                    'id'   => $projectLabelId,
                    'sort' => $k,
                ];
            }
            ProjectLabel::repository()->insertAll($updateData, replace:['id', 'sort']);
        });

        $this->w->flush();
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
