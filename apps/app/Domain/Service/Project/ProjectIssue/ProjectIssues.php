<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectIssue;

use Closure;
use App\Domain\Entity\Project\ProjectIssue;
use App\Domain\Entity\Project\ProjectUser;
use App\Domain\Service\Support\Read;
use Leevel\Collection\TypedIntArray;
use Leevel\Database\Condition;
use Leevel\Database\Ddd\Select;

/**
 * 项目问题列表.
 */
class ProjectIssues
{
    use Read;

    public function handle(ProjectIssuesParams $params): array
    {
        return $this->findLists($params, ProjectIssue::class);
    }

    /**
     * 用户 ID 条件.
     */
    private function userIdSpec(Select $select, int $value): void
    {
        $select->where('project_user.user_id', $value);
    }

    /**
     * 项目 ID 条件.
     */
    private function projectIdsSpec(Select $select, TypedIntArray $value): void
    {
        $select->whereIn('project_id', $value->toArray());
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

    private function conditionCall(ProjectIssuesParams $params): ?Closure
    {
        return function(Select $select) use($params) {
            $select->eager([
                'project_type',
                'project_releases',
                'project_tags',
                'project_modules',
            ]);

            if (!$params->userId && !$params->type) {
                return null;
            }

            $select
                ->leftJoin('project_user', '', function (Condition $select) {
                    $select
                        ->where('delete_at', 0)
                        ->where('data_id', Condition::raw('[project_issue.id]'))
                        ->where('data_type', ProjectUser::DATA_TYPE_ISSUE);
                });
        };
    }
}
