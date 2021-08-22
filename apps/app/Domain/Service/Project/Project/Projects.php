<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\Project;

use Closure;
use App\Domain\Entity\Project\Project;
use App\Domain\Entity\Project\ProjectUser;
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

    /**
     * 用户 ID 条件.
     */
    private function userIdSpec(Select $select, int $value): void
    {
        $select->where('project_user.user_id', $value);
    }

    /**
     * 类型条件.
     */
    private function typeSpec(Select $select, string $value): void
    {
        switch ($value) {
            case 'favor':
                $select->where('project_user.type', ProjectUser::TYPE_FAVOR);
                break;
            case 'administrator':
                $select->where('project_user.type', ProjectUser::TYPE_MEMBER);
                $select->where('project_user.extend_type', ProjectUser::EXTEND_TYPE_ADMINISTRATOR);
                break;
            default:
                // member
                $select->where('project_user.type', ProjectUser::TYPE_MEMBER);
                break;
        }
    }

    private function conditionCall(ProjectsParams $params): ?Closure
    {
        if (!$params->userId && !$params->type) {
            return null;
        }

        return function(Select $select) {
            $select
                ->leftJoin('project_user', '', function (Condition $select) {
                    $select
                        ->where('data_id', Condition::raw('[project.id]'))
                        ->where('data_type', ProjectUser::DATA_TYPE_PROJECT);
                });
        };
    }
}
