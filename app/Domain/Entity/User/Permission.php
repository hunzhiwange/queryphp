<?php

declare(strict_types=1);

namespace App\Domain\Entity\User;

use App\Infra\Repository\User\Permission as RepositoryPermission;
use Leevel\Database\Ddd\Entity;
use Leevel\Database\Ddd\Relation\ManyMany;

/**
 * 权限.
 */
class Permission extends Entity
{
    /**
     * Database table.
     */
    public const TABLE = 'permission';

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
     * - pid
     *                   comment: 父级 ID  type: bigint(20) unsigned  null: false
     *                   key: MUL  default: 0  extra:
     * - name
     *                   comment: 权限名字  type: varchar(64)  null: false
     *                   key: MUL  default:   extra:
     * - num
     *                   comment: 编号  type: varchar(64)  null: false
     *                   key: MUL  default:   extra:
     * - status
     *                   comment: 状态 0=禁用;1=启用;  type: tinyint(1) unsigned  null: false
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
        'pid' => [
            self::COLUMN_NAME => '父级 ID',
        ],
        'name' => [
            self::COLUMN_NAME => '权限名字',
        ],
        'num' => [
            self::COLUMN_NAME => '编号',
        ],
        'status' => [
            self::COLUMN_NAME => '状态 0=禁用;1=启用;',
            self::ENUM_CLASS => PermissionStatusEnum::class,
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
        'resource' => [
            self::MANY_MANY => Resource::class,
            self::MIDDLE_ENTITY => PermissionResource::class,
            self::SOURCE_KEY => 'id',
            self::TARGET_KEY => 'id',
            self::MIDDLE_SOURCE_KEY => 'permission_id',
            self::MIDDLE_TARGET_KEY => 'resource_id',
            self::RELATION_SCOPE => 'resource',
        ],
    ]; // END STRUCT

    /**
     * Soft delete column.
     */
    public const DELETE_AT = 'delete_at';

    /**
     * 仓储.
     */
    public const REPOSITORY = RepositoryPermission::class;

    /**
     * 资源关联查询作用域.
     */
    protected function relationScopeResource(ManyMany $relation): void
    {
        $relation
            ->where('status', ResourceStatusEnum::ENABLE->value)
            ->setColumns(['id', 'name', 'num', 'status'])
        ;
    }
}
