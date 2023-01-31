<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectIssue;

use App\Domain\Entity\Project\ProjectIssue;
use App\Domain\Entity\Project\ProjectUser;
use App\Domain\Entity\Project\ProjectUserDataTypeEnum;
use App\Domain\Entity\Project\ProjectUserExtendTypeEnum;
use App\Domain\Entity\Project\ProjectUserTypeEnum;
use App\Domain\Service\Support\Read;
use App\Domain\Service\Support\Spec\Project\ProjectIds;
use Closure;
use Leevel\Database\Condition;
use Leevel\Database\Ddd\Select;

/**
 * 项目问题列表.
 */
class ProjectIssues
{
    use Read;
    use ProjectIds;

    protected string $entityClass = ProjectIssue::class;

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
                $select->where('project_user.type', ProjectUserTypeEnum::FAVOR->value);
                break;
            case 'administrator':
                $select->where('project_user.type', ProjectUserTypeEnum::MEMBER->value);
                $select->where('project_user.extend_type', ProjectUserExtendTypeEnum::ADMINISTRATOR->value);
                break;
            default:
                // member
                $select->where('project_user.type', ProjectUserTypeEnum::MEMBER->value);
                break;
        }
    }

    private function conditionCall(ProjectIssuesParams $params): ?Closure
    {
        return function (Select $select) use ($params) {
            $select->eager([
                'project',
                'project_label',
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
                        ->where('data_type', ProjectUserDataTypeEnum::ISSUE->value);
                });
        };
    }
}
