<?php

declare(strict_types=1);

/*
 * This file is part of the your app package.
 *
 * The PHP Application For Code Poem For You.
 * (c) 2018-2099 http://yourdomian.com All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Common\Domain\Entity\User;

use Leevel\Database\Ddd\Entity;
use Leevel\Database\Ddd\GetterSetter;
use Leevel\Database\Ddd\Relation\ManyMany;

/**
 * 角色.
 */
class Role extends Entity
{
    use GetterSetter;

    /**
     * Database table.
     */
    const TABLE = 'role';

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
     *                   comment: 角色名字  type: varchar(64)  null: false
     *                   key:   default:   extra:
     * - num
     *                   comment: 编号  type: varchar(64)  null: false
     *                   key: MUL  default:   extra:
     * - status
     *                   comment: 状态 0=禁用;1=启用;  type: tinyint(4) unsigned  null: false
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
        'permission'      => [
            self::MANY_MANY              => Permission::class,
            self::MIDDLE_ENTITY          => RolePermission::class,
            self::SOURCE_KEY             => 'id',
            self::TARGET_KEY             => 'id',
            self::MIDDLE_SOURCE_KEY      => 'role_id',
            self::MIDDLE_TARGET_KEY      => 'permission_id',
            self::RELATION_SCOPE         => 'permission',
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
     * 权限关联查询作用域.
     */
    protected function relationScopePermission(ManyMany $relation): void
    {
        $relation
            ->where('status', 1)
            ->setColumns(['id', 'name']);
    }
}
