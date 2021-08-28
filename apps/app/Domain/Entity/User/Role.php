<?php

declare(strict_types=1);

namespace App\Domain\Entity\User;

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
    public const TABLE = 'role';

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
     *                   comment: 角色名字  type: varchar(64)  null: false  
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
        'name' => [
            self::COLUMN_NAME => '角色名字',
        ],
        'num' => [
            self::COLUMN_NAME => '编号',
        ],
        'status' => [
            self::COLUMN_NAME => '状态 0=禁用;1=启用;',
        ],
        'create_at' => [
            self::COLUMN_NAME => '创建时间',
        ],
        'update_at' => [
            self::COLUMN_NAME => '更新时间',
            self::SHOW_PROP_BLACK => true,
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
        'permission'      => [
            self::MANY_MANY              => Permission::class,
            self::MIDDLE_ENTITY          => RolePermission::class,
            self::SOURCE_KEY             => 'id',
            self::TARGET_KEY             => 'id',
            self::MIDDLE_SOURCE_KEY      => 'role_id',
            self::MIDDLE_TARGET_KEY      => 'permission_id',
            self::RELATION_SCOPE         => 'permission',
        ],
    ]; // END STRUCT

    /**
     * Soft delete column.
     */
    public const DELETE_AT = 'delete_at';

    /**
     * 状态值.
     */
    
    #[status('禁用')]
    public const STATUS_DISABLE = 0;

    #[status('启用')]
    public const STATUS_ENABLE = 1;

    /**
     * 权限关联查询作用域.
     */
    protected function relationScopePermission(ManyMany $relation): void
    {
        $relation
            ->where('status', Permission::STATUS_ENABLE)
            ->setColumns(['id', 'name']);
    }
}
