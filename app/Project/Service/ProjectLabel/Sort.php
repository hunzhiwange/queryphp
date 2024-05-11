<?php

declare(strict_types=1);

namespace App\Project\Service\ProjectLabel;

use App\Project\Entity\Project;
use App\Project\Entity\ProjectLabel;
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

        $projectLabelIds = $params->projectLabelIds->toArray();
        ProjectLabel::repository()->validateDataExists($projectLabelIds);

        $this->w->persist(function () use ($projectLabelIds): void {
            $updateData = [];
            foreach ($projectLabelIds as $k => $projectLabelId) {
                $updateData[] = [
                    'id' => $projectLabelId,
                    'sort' => $k,
                ];
            }
            ProjectLabel::repository()->insertAll($updateData, replace: ['id', 'sort']);
        });

        $this->w->flush();
    }
}
