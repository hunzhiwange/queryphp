<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectRelease;

use Closure;
use App\Domain\Entity\Project\ProjectRelease;
use App\Domain\Service\Support\Read;
use App\Domain\Service\Project\ProjectRelease\ProjectReleasesParams;
use Leevel\Database\Ddd\Select;

/**
 * 项目版本列表.
 */
class ProjectReleases
{
    use Read;

    public function handle(ProjectReleasesParams $params): array
    {
        return $this->findLists($params, ProjectRelease::class);
    }

    private function conditionCall(ProjectReleasesParams $params): ?Closure
    {
        return function(Select $select) use($params) {
            $select->eager([
                'project',
            ]);
        };
    }
}
