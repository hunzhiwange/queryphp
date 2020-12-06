<?php

declare(strict_types=1);

namespace Common\Domain\Entity\User;

use Leevel\Database\Ddd\Entity;
use Leevel\Database\Ddd\GetterSetter;
use Leevel\Database\Ddd\Relation\ManyMany;

/**
 * 用户.
 */
class User extends Entity
{
    use GetterSetter;

    /**
     * Database table.
     */
    const TABLE = 'user';

    /**
     * Primary key.
     */
    const ID = 'id';

    /**
     * Auto increment.
     */
    const AUTO = 'id';

    /**
     * Entity struct.
     *
     * - id
     *                   comment: ID  type: bigint(20) unsigned  null: false
     *                   key: PRI  default: null  extra: auto_increment
     * - name
     *                   comment: 用户名字  type: varchar(64)  null: false
     *                   key:   default:   extra:
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
     *                   comment: 状态 0=禁用;1=启用;  type: tinyint(4)  null: false
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
    const STRUCT = [
        'id' => [
            self::READONLY => true,
        ],
        'name' => [
        ],
        'num' => [
        ],
        'password' => [
            self::SHOW_PROP_BLACK => true,
        ],
        'email' => [
        ],
        'mobile' => [
        ],
        'status' => [
        ],
        'create_at' => [
        ],
        'update_at' => [
            self::SHOW_PROP_BLACK => true,
        ],
        'delete_at' => [
            self::SHOW_PROP_BLACK => true,
        ],
        'create_account' => [
            self::SHOW_PROP_BLACK => true,
        ],
        'update_account' => [
            self::SHOW_PROP_BLACK => true,
        ],
        'version' => [
        ],
        'role'      => [
            self::MANY_MANY              => Role::class,
            self::MIDDLE_ENTITY          => UserRole::class,
            self::SOURCE_KEY             => 'id',
            self::TARGET_KEY             => 'id',
            self::MIDDLE_SOURCE_KEY      => 'user_id',
            self::MIDDLE_TARGET_KEY      => 'role_id',
            self::RELATION_SCOPE         => 'role',
        ],
    ];

    /**
     * Soft delete column.
     */
    const DELETE_AT = 'delete_at';

    /**
     * 状态值.
     */
    const STATUS_ENUM = [
        'disable' => [0, '禁用'],
        'enable'  => [1, '启用'],
    ];

    /**
     * 角色关联查询作用域.
     */
    protected function relationScopeRole(ManyMany $relation): void
    {
        $relation
            ->where('status', 1)
            ->setColumns(['id', 'name']);
    }
}
