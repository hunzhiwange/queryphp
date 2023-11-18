<?php

declare(strict_types=1);

namespace App\Project\Service\ProjectTag;

use App\Infra\Service\Support\Read;
use Leevel\Database\Ddd\Select;

/**
 * 项目标签列表.
 */
class ProjectTags
{
    use Read;

    private function conditionCall(ProjectTagsParams $params): \Closure
    {
        return function (Select $select): void {
            $select->eager([
                'project',
            ]);
        };
    }
}
