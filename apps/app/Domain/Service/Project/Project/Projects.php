<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\Project;

use Closure;
use App\Domain\Entity\Project\Project;
use App\Domain\Service\Support\Read;
use Leevel\Database\Condition;
use Leevel\Database\Ddd\Select;

/**
 * 项目列表.
 */
class Projects
{
    use Read;

    public function handle(ProjectsParams $params): array
    {
        return $this->findLists($params, Project::class);
    }

    private function conditionCall(): ?Closure
    {
        return function(Select $select) {
            $select->leftJoin('project_user', '*', 'project_id', '=', Condition::raw('[project.id]'));
        };
    }
}
