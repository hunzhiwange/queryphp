<?php

declare(strict_types=1);

namespace App\Project\Service\ProjectModule;

use App\Infra\Service\Support\Read;
use Leevel\Database\Ddd\Select;

/**
 * 项目模块列表.
 */
class ProjectModules
{
    use Read;

    private function conditionCall(ProjectModulesParams $params): \Closure
    {
        return function (Select $select): void {
            $select->eager([
                'project',
            ]);
        };
    }
}
