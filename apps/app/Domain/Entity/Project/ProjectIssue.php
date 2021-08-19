<?php

declare(strict_types=1);

namespace App\Domain\Entity\Project;

use Leevel\Database\Ddd\Entity;
use Leevel\Database\Ddd\GetterSetter;

/**
 * 项目问题.
 */
class ProjectIssue extends Entity
{
    use GetterSetter;

    /**
     * Database table.
     */
    public const TABLE = 'project_issue';

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
     * - project_id
     *                     comment: 项目ID  type: bigint(20)  null: true  
     *                     key:   default: 0  extra: 
     * - project_label_id
     *                     comment: 项目分类 ID  type: bigint(20)  null: true  
     *                     key:   default: 0  extra: 
     * - project_type_id
     *                     comment: 项目问题类型 ID  type: bigint(20)  null: true  
     *                     key:   default: 0  extra: 
     * - owner_user_id
     *                     comment: 负责人用户 ID  type: bigint(20)  null: true  
     *                     key:   default: 0  extra: 
     * - title
     *                     comment: 标题  type: varchar(255)  null: true  
     *                     key:   default:   extra: 
     * - desc
     *                     comment: 描述  type: varchar(500)  null: true  
     *                     key:   default:   extra: 
     * - level
     *                     comment: 优先级别：1~4  type: tinyint(1)  null: true  
     *                     key:   default: 1  extra: 
     * - completed
     *                     comment: 是否完成：1=未完成;2=已完成;  type: tinyint(1)  null: true  
     *                     key:   default: 1  extra: 
     * - completed_date
     *                     comment: 创建时间  type: datetime  null: false  
     *                     key:   default: null  extra: 
     * - sub_task
     *                     comment: 子任务列表  type: text  null: true  
     *                     key:   default: null  extra: 
     * - follower
     *                     comment: 关注人列表  type: text  null: true  
     *                     key:   default: null  extra: 
     * - push_id
     *                     comment: 已发送的最后动态 ID  type: bigint(20)  null: true  
     *                     key:   default: 0  extra: 
     * - file_number
     *                     comment: 附件数量  type: bigint(20)  null: true  
     *                     key:   default: 0  extra: 
     * - start_date
     *                     comment: 计划开始时间  type: datetime  null: false  
     *                     key:   default: null  extra: 
     * - end_date
     *                     comment: 计划结束时间  type: datetime  null: false  
     *                     key:   default: null  extra: 
     * - archived
     *                     comment: 是否归档  type: tinyint(4)  null: true  
     *                     key:   default: 0  extra: 
     * - archived_date
     *                     comment: 归档时间  type: datetime  null: false  
     *                     key:   default: null  extra: 
     * - sort
     *                     comment: 排序(DESC)  type: bigint(20)  null: true  
     *                     key:   default: 0  extra: 
     * - user_order
     *                     comment: 会员自己的排序(DESC)  type: bigint(20)  null: true  
     *                     key:   default: 0  extra: 
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
        'project_id' => [
            self::COLUMN_NAME => '项目ID',
        ],
        'project_label_id' => [
            self::COLUMN_NAME => '项目分类 ID',
        ],
        'project_type_id' => [
            self::COLUMN_NAME => '项目问题类型 ID',
        ],
        'owner_user_id' => [
            self::COLUMN_NAME => '负责人用户 ID',
        ],
        'title' => [
            self::COLUMN_NAME => '标题',
        ],
        'desc' => [
            self::COLUMN_NAME => '描述',
        ],
        'level' => [
            self::COLUMN_NAME => '优先级别：1~4',
        ],
        'completed' => [
            self::COLUMN_NAME => '是否完成：1=未完成;2=已完成;',
        ],
        'completed_date' => [
            self::COLUMN_NAME => '创建时间',
        ],
        'sub_task' => [
            self::COLUMN_NAME => '子任务列表',
        ],
        'follower' => [
            self::COLUMN_NAME => '关注人列表',
        ],
        'push_id' => [
            self::COLUMN_NAME => '已发送的最后动态 ID',
        ],
        'file_number' => [
            self::COLUMN_NAME => '附件数量',
        ],
        'start_date' => [
            self::COLUMN_NAME => '计划开始时间',
        ],
        'end_date' => [
            self::COLUMN_NAME => '计划结束时间',
        ],
        'archived' => [
            self::COLUMN_NAME => '是否归档',
        ],
        'archived_date' => [
            self::COLUMN_NAME => '归档时间',
        ],
        'sort' => [
            self::COLUMN_NAME => '排序(DESC)',
        ],
        'user_order' => [
            self::COLUMN_NAME => '会员自己的排序(DESC)',
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
