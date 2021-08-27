<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectLabel;

use App\Domain\Entity\Project\ProjectLabel;
use App\Domain\Service\Support\Read;
use Leevel\Collection\TypedIntArray;
use Leevel\Database\Ddd\Select;

/**
 * 项目分类列表.
 */
class ProjectLabels
{
    use Read;

    public function handle(ProjectLabelsParams $params): array
    {
        return $this->findLists($params, ProjectLabel::class);
    }

    /**
     * 项目 ID 条件.
     */
    private function projectIdsSpec(Select $select, TypedIntArray $value): void
    {
        $select->whereIn('project_id', $value->toArray());
    }
}
