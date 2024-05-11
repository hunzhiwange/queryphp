<?php

declare(strict_types=1);

namespace App\Project\Service\ProjectIssue;

use App\Infra\Service\Support\Read;
use App\Project\Entity\ProjectIssue;
use App\Project\Entity\ProjectUserDataTypeEnum;
use App\Project\Entity\ProjectUserExtendTypeEnum;
use App\Project\Entity\ProjectUserTypeEnum;
use App\Project\Service\Support\ProjectIdsSpec;
use Leevel\Database\Condition;
use Leevel\Database\Ddd\Select;

/**
 * 项目问题列表.
 */
class ProjectIssues
{
    use ProjectIdsSpec;
    use Read;

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

    private function conditionCall(ProjectIssuesParams $params): \Closure
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
                return function (): void {};
            }

            $select
                ->leftJoin('project_user', '', function (Condition $select): void {
                    $select
                        ->where('delete_at', 0)
                        ->where('data_id', Condition::raw(sprintf('[%s.id]', ProjectIssue::table())))
                        ->where('data_type', ProjectUserDataTypeEnum::ISSUE->value)
                    ;
                })
            ;
        };
    }
}
