<?php

declare(strict_types=1);

namespace App\Domain\Entity\User;

use App\Infra\Repository\User\User as RepositoryUser;
use Leevel\Database\Ddd\Entity;
use Leevel\Database\Ddd\Relation\ManyMany;

/**
 * 用户.
 */
class User extends Entity
{
    /**
     * Database table.
     */
    public const TABLE = 'user';

    /**
     * Primary key.
     */
    public const ID = 'id';

    /**
     * Auto increment.
     */
    public const AUTO = 'id';

    /**
     * Entity struct.
     *
     * - id
     *                   comment: ID  type: bigint(20) unsigned  null: false
     *                   key: PRI  default: null  extra: auto_increment
     * - name
     *                   comment: 用户名字  type: varchar(64)  null: false
     *                   key: MUL  default:   extra:
     * - num
     *                   comment: 编号  type: varchar(64)  null: false
     *                   key: MUL  default:   extra:
     * - password
     *                   comment: 密码  type: varchar(255)  null: false
     *                   key:   default:   extra:
     * - email
     *                   comment: Email  type: varchar(100)  null: false
     *                   key:   default:   extra:
     * - mobile
     *                   comment: 手机  type: char(11)  null: false
     *                   key:   default:   extra:
     * - status
     *                   comment: 状态 0=禁用;1=启用;  type: tinyint(1)  null: false
     *                   key:   default: 1  extra:
     * - create_at
     *                   comment: 创建时间  type: datetime  null: false
     *                   key:   default: CURRENT_TIMESTAMP  extra:
     * - update_at
     *                   comment: 更新时间  type: datetime  null: false
     *                   key:   default: CURRENT_TIMESTAMP  extra: on update CURRENT_TIMESTAMP
     * - delete_at
     *                   comment: 删除时间 0=未删除;大于0=删除时间;  type: bigint(20) unsigned  null: false
     *                   key:   default: 0  extra:
     * - create_account
     *                   comment: 创建账号  type: bigint(20) unsigned  null: false
     *                   key:   default: 0  extra:
     * - update_account
     *                   comment: 更新账号  type: bigint(20) unsigned  null: false
     *                   key:   default: 0  extra:
     * - version
     *                   comment: 操作版本号  type: bigint(20) unsigned  null: false
     *                   key:   default: 0  extra:
     */
    public const STRUCT = [
        'id' => [
            self::COLUMN_NAME => 'ID',
            self::READONLY => true,
        ],
        'name' => [
            self::COLUMN_NAME => '用户名字',
        ],
        'num' => [
            self::COLUMN_NAME => '编号',
        ],
        'password' => [
            self::COLUMN_NAME => '密码',
        ],
        'email' => [
            self::COLUMN_NAME => 'Email',
        ],
        'mobile' => [
            self::COLUMN_NAME => '手机',
        ],
        'status' => [
            self::COLUMN_NAME => '状态 0=禁用;1=启用;',
            self::ENUM_CLASS => UserStatusEnum::class,
        ],
        'create_at' => [
            self::COLUMN_NAME => '创建时间',
        ],
        'update_at' => [
            self::COLUMN_NAME => '更新时间',
        ],
        'delete_at' => [
            self::COLUMN_NAME => '删除时间 0=未删除;大于0=删除时间;',
            self::SHOW_PROP_BLACK => true,
        ],
        'create_account' => [
            self::COLUMN_NAME => '创建账号',
            self::SHOW_PROP_BLACK => true,
        ],
        'update_account' => [
            self::COLUMN_NAME => '更新账号',
            self::SHOW_PROP_BLACK => true,
        ],
        'version' => [
            self::COLUMN_NAME => '操作版本号',
        ],
        'role' => [
            self::MANY_MANY => Role::class,
            self::MIDDLE_ENTITY => UserRole::class,
            self::SOURCE_KEY => 'id',
            self::TARGET_KEY => 'id',
            self::MIDDLE_SOURCE_KEY => 'user_id',
            self::MIDDLE_TARGET_KEY => 'role_id',
            self::RELATION_SCOPE => 'role',
        ],
    ]; // END STRUCT

    /**
     * Soft delete column.
     */
    public const DELETE_AT = 'delete_at';

    /**
     * 仓储.
     */
    public const REPOSITORY = RepositoryUser::class;

    public static function repository(?Entity $entity = null): RepositoryUser
    {
        return parent::repository($entity);
    }

    /**
     * 角色关联查询作用域.
     */
    protected function relationScopeRole(ManyMany $relation): void
    {
        $relation
            ->where('status', UserStatusEnum::ENABLE->value)
            ->setColumns(['id', 'name'])
        ;
    }
}
