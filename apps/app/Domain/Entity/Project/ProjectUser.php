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
     *                   comment: ID  type: bigint(20) unsigned  null: false  
     *                   key: PRI  default: null  extra: auto_increment
     * - user_id
     *                   comment: 用户 ID  type: bigint(20) unsigned  null: false  
     *                   key: MUL  default: 0  extra: 
     * - type
     *                   comment: 类型 1=成员;2=收藏;3=关注;  type: tinyint(1) unsigned  null: false  
     *                   key:   default: 1  extra: 
     * - extend_type
     *                   comment: 扩展类型 1=成员;2=管理员;  type: tinyint(1) unsigned  null: false  
     *                   key:   default: 1  extra: 
     * - data_type
     *                   comment: 数据类型 1=项目;2=问题;  type: tinyint(1) unsigned  null: false  
     *                   key:   default: 1  extra: 
     * - data_id
     *                   comment: 数据 ID  type: bigint(20) unsigned  null: false  
     *                   key:   default: 0  extra: 
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
        'user_id' => [
            self::COLUMN_NAME => '用户 ID',
        ],
        'type' => [
            self::COLUMN_NAME => '类型 1=成员;2=收藏;3=关注;',
        ],
        'extend_type' => [
            self::COLUMN_NAME => '扩展类型 1=成员;2=管理员;',
        ],
        'data_type' => [
            self::COLUMN_NAME => '数据类型 1=项目;2=问题;',
        ],
        'data_id' => [
            self::COLUMN_NAME => '数据 ID',
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
        'user.name' => [
            self::VIRTUAL_COLUMN => true,
        ],
        'user.num' => [
            self::VIRTUAL_COLUMN => true,
        ],
    ]; // END STRUCT

    /**
     * 类型.
     */
    
    #[type('成员')]
    public const TYPE_MEMBER = 1;

    #[type('收藏')]
    public const TYPE_FAVOR = 2;

    #[type('关注')]
    public const TYPE_FOLLOW = 3;

    /**
     * 扩展类型.
     */
    
    #[extend_type('成员')]
    public const EXTEND_TYPE_MEMBER = 1;

    #[extend_type('管理')]
    public const EXTEND_TYPE_ADMINISTRATOR = 2;

    /**
     * 数据类型.
     */
    
    #[data_type('项目')]
    public const DATA_TYPE_PROJECT = 1;

    #[data_type('问题')]
    public const DATA_TYPE_ISSUE = 2;

    /**
     * Soft delete column.
     */
    public const DELETE_AT = 'delete_at';
}
