<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectTag;

use App\Domain\Entity\Project\ProjectTag;
use App\Domain\Service\Support\Read;
use Closure;
use Leevel\Database\Ddd\Select;

/**
 * 项目标签列表.
 */
class ProjectTags
{
    use Read;

    public function handle(ProjectTagsParams $params): array
    {
        return $this->findLists($params, ProjectTag::class);
    }

    private function conditionCall(ProjectTagsParams $params): ?Closure
    {
        return function (Select $select) {
            $select->eager([
                'project',
            ]);
        };
    }
}
