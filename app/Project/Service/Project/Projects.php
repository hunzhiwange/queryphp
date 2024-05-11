<?php

declare(strict_types=1);

namespace App\Project\Service\Project;

use App\Infra\Service\Support\Read;
use App\Project\Entity\ProjectUserTypeEnum;
use Leevel\Database\Condition;
use Leevel\Database\Ddd\Select;
use Leevel\Support\VectorInt;

/**
 * 项目列表.
 */
class Projects
{
    use Read;

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
    private function projectIdsSpec(Select $select, VectorInt $value): void
    {
        $select->whereIn('id', $value->toArray());
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
                $select->where('project_user.type', \App\Project\Entity\ProjectUserTypeEnum::MEMBER->value);
                $select->where('project_user.extend_type', \App\Project\Entity\ProjectUserExtendTypeEnum::ADMINISTRATOR->value);

                break;

            default:
                // member
                $select->where('project_user.type', ProjectUserTypeEnum::MEMBER->value);

                break;
        }
    }

    private function conditionCall(ProjectsParams $params): \Closure
    {
        if (!$params->userId && !$params->type) {
            return function (): void {};
        }

        return function (Select $select): void {
            $select
                ->leftJoin('project_user', '', function (Condition $select): void {
                    $select
                        ->where('delete_at', 0)
                        ->where('data_id', Condition::raw('[project.id]'))
                        ->where('data_type', \App\Project\Entity\ProjectUserDataTypeEnum::PROJECT->value)
                    ;
                })
            ;
        };
    }
}
