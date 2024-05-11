<?php

declare(strict_types=1);

namespace App\Project\Service\ProjectLabel;

use App\Infra\Service\Support\Read;
use App\Project\Service\Support\ProjectIdsSpec;
use Leevel\Database\Ddd\Select;

/**
 * 项目分类列表.
 */
class ProjectLabels
{
    use ProjectIdsSpec;
    use Read;

    private function conditionCall(ProjectLabelsParams $params): \Closure
    {
        return function (Select $select): void {
            $select->eager([
                'project',
            ]);
        };
    }
}
