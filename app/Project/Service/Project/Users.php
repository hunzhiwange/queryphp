<?php

declare(strict_types=1);

namespace App\Project\Service\Project;

use App\Infra\Service\Support\Read;
use App\Project\Entity\ProjectUserTypeEnum;
use Leevel\Database\Condition;
use Leevel\Database\Ddd\Select;

/**
 * 项目用户列表.
 */
class Users
{
    use Read;

    /**
     * 项目 ID 条件.
     */
    private function projectIdSpec(Select $select, int $value): void
    {
        $select->where('data_id', $value);
    }

    /**
     * 初始化规约.
     */
    private function initializationSpec(Select $select, bool $value, UsersParams $params): void
    {
        $select->where('type', ProjectUserTypeEnum::MEMBER->value);
    }

    private function conditionCall(UsersParams $params): \Closure
    {
        return function (Select $select): void {
            $select
                ->leftJoin('user', [
                    'user.name AS user.name',
                    'user.num AS user.num',
                ], function (Condition $select): void {
                    $select
                        ->where('id', Condition::raw('[project_user.user_id]'))
                    ;
                })
            ;
        };
    }
}
