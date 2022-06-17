<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\Project;

use App\Domain\Entity\Project\ProjectUser;
use App\Domain\Service\Support\Read;
use Closure;
use Leevel\Database\Condition;
use Leevel\Database\Ddd\Select;

/**
 * 项目用户列表.
 */
class Users
{
    use Read;

    public function handle(UsersParams $params): array
    {
        return $this->findLists($params, ProjectUser::class);
    }

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
        $select->where('type', ProjectUser::TYPE_MEMBER);
    }

    private function conditionCall(UsersParams $params): ?Closure
    {
        return function (Select $select) {
            $select
                ->leftJoin('user', [
                    'user.name AS user.name',
                    'user.num AS user.num',
                ], function (Condition $select) {
                    $select
                        ->where('id', Condition::raw('[project_user.user_id]'));
                });
        };
    }
}
