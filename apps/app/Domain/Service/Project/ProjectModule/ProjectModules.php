<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectModule;

use Closure;
use App\Domain\Entity\Project\ProjectModule;
use App\Domain\Service\Support\Read;
use App\Domain\Service\Project\ProjectModule\ProjectModulesParams;
use Leevel\Database\Ddd\Select;

/**
 * 项目模块列表.
 */
class ProjectModules
{
    use Read;

    public function handle(ProjectModulesParams $params): array
    {
        return $this->findLists($params, ProjectModule::class);
    }

    private function conditionCall(ProjectModulesParams $params): ?Closure
    {
        return function(Select $select) use($params) {
            $select->eager([
                'project',
            ]);
        };
    }
}
