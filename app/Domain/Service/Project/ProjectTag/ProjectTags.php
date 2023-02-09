<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectTag;

use App\Domain\Entity\Project\ProjectTag;
use App\Domain\Service\Support\Read;
use Leevel\Database\Ddd\Select;

/**
 * 项目标签列表.
 */
class ProjectTags
{
    use Read;

    protected string $entityClass = ProjectTag::class;

    private function conditionCall(ProjectTagsParams $params): \Closure
    {
        return function (Select $select): void {
            $select->eager([
                'project',
            ]);
        };
    }
}
