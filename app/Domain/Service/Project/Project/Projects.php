<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\Project;

use App\Domain\Entity\Project\Project;
use App\Domain\Entity\Project\ProjectUserDataTypeEnum;
use App\Domain\Entity\Project\ProjectUserExtendTypeEnum;
use App\Domain\Entity\Project\ProjectUserTypeEnum;
use App\Domain\Service\Support\Read;
use Closure;
use Leevel\Database\Condition;
use Leevel\Database\Ddd\Select;
use Leevel\Support\TypedIntArray;

/**
 * 项目列表.
 */
class Projects
{
    use Read;

    protected string $entityClass = Project::class;

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
                $select->where('project_user.type', ProjectUserTypeEnum::MEMBER->value);
                $select->where('project_user.extend_type', ProjectUserExtendTypeEnum::ADMINISTRATOR->value);
                break;
            default:
                // member
                $select->where('project_user.type', ProjectUserTypeEnum::MEMBER->value);
                break;
        }
    }

    private function conditionCall(ProjectsParams $params): ?Closure
    {
        if (!$params->userId && !$params->type) {
            return null;
        }

        return function (Select $select) {
            $select
                ->leftJoin('project_user', '', function (Condition $select) {
                    $select
                        ->where('delete_at', 0)
                        ->where('data_id', Condition::raw('[project.id]'))
                        ->where('data_type', ProjectUserDataTypeEnum::PROJECT->value);
                });
        };
    }
}
