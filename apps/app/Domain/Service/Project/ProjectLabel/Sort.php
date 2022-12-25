<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectLabel;

use App\Domain\Entity\Project\Project;
use App\Domain\Entity\Project\ProjectLabel;
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

    public function sort(SortParams $params): void
    {
        Project::repository()->findOrFail($params->projectId);

        // 检测是否为所有 label，不是直接报错
        $projectLabelIds = $params->projectLabelIds->toArray();
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
     * 组装实体数据.
     */
    private function data(SortParams $params): array
    {
        return $params->toArray();
    }
}
