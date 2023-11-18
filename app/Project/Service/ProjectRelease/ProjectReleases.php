<?php

declare(strict_types=1);

namespace App\Project\Service\ProjectRelease;

use App\Infra\Service\Support\Read;
use App\Project\Service\Support\ProjectIdsSpec;
use Leevel\Database\Ddd\Select;

/**
 * 项目版本列表.
 */
class ProjectReleases
{
    use ProjectIdsSpec;
    use Read;

    private function conditionCall(ProjectReleasesParams $params): \Closure
    {
        return function (Select $select): void {
            $select->eager([
                'project',
            ]);
        };
    }
}
