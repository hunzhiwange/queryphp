<?php

declare(strict_types=1);

namespace App\Domain\Entity\Project;

use Leevel\Database\Ddd\Entity;
use Leevel\Database\Ddd\GetterSetter;

/**
 * 项目用户.
 */
class ProjectUser extends Entity
{
    use GetterSetter;

    /**
     * Database table.
     */
    public const TABLE = 'project_user';

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
     *                     comment: ID  type: bigint(20) unsigned  null: false  
     *                     key: PRI  default: null  extra: auto_increment
     * - type
     *                     comment: 类型 1=成员;2=收藏;3=关注;  type: tinyint(1)  null: true  
     *                     key:   default: 1  extra: 
     * - project_id
     *                     comment: 项目ID  type: bigint(20)  null: true  
     *                     key:   default: 0  extra: 
     * - project_issue_id
     *                     comment: 任务ID  type: bigint(20)  null: true  
     *                     key:   default: 0  extra: 
     * - is_owner
     *                     comment: 是否项目所有者 1=否;2=是;  type: tinyint(1)  null: true  
     *                     key:   default: 1  extra: 
     * - create_at
     *                     comment: 创建时间  type: datetime  null: false  
     *                     key:   default: CURRENT_TIMESTAMP  extra: 
     * - update_at
     *                     comment: 更新时间  type: datetime  null: false  
     *                     key:   default: CURRENT_TIMESTAMP  extra: on update CURRENT_TIMESTAMP
     * - delete_at
     *                     comment: 删除时间 0=未删除;大于0=删除时间;  type: bigint(20) unsigned  null: false  
     *                     key:   default: 0  extra: 
     * - create_account
     *                     comment: 创建账号  type: bigint(20) unsigned  null: false  
     *                     key:   default: 0  extra: 
     * - update_account
     *                     comment: 更新账号  type: bigint(20) unsigned  null: false  
     *                     key:   default: 0  extra: 
     * - version
     *                     comment: 操作版本号  type: bigint(20) unsigned  null: false  
     *                     key:   default: 0  extra: 
     */
    public const STRUCT = [
        'id' => [
            self::COLUMN_NAME => 'ID',
            self::READONLY => true,
        ],
        'type' => [
            self::COLUMN_NAME => '类型 1=成员;2=收藏;3=关注;',
        ],
        'project_id' => [
            self::COLUMN_NAME => '项目ID',
        ],
        'project_issue_id' => [
            self::COLUMN_NAME => '任务ID',
        ],
        'is_owner' => [
            self::COLUMN_NAME => '是否项目所有者 1=否;2=是;',
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
    ]; // END STRUCT

    /**
     * Soft delete column.
     */
    public const DELETE_AT = 'delete_at';
}
