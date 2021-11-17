<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectLabel;

use App\Domain\Entity\Project\ProjectLabel;
use App\Domain\Service\Support\Read;
use App\Domain\Service\Support\Spec\Project\ProjectIds;
use Closure;
use Leevel\Database\Ddd\Select;

/**
 * 项目分类列表.
 */
class ProjectLabels
{
    use Read;
    use ProjectIds;

    public function handle(ProjectLabelsParams $params): array
    {
        return $this->findLists($params, ProjectLabel::class);
    }

    private function conditionCall(ProjectLabelsParams $params): ?Closure
    {
        return function (Select $select) {
            $select->eager([
                'project',
            ]);
        };
    }
}
