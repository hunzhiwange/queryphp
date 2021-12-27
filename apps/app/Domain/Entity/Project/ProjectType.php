<?php

declare(strict_types=1);

namespace App\Domain\Entity\Project;

use Leevel\Database\Ddd\Entity;
use Leevel\Database\Ddd\GetterSetter;

/**
 * 项目问题类型.
 */
class ProjectType extends Entity
{
    use GetterSetter;

    /**
     * Database table.
     */
    public const TABLE = 'project_type';

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
     * - company_id
     *                   comment: 公司 ID  type: bigint(20) unsigned  null: false  
     *                   key: MUL  default: 1  extra: 
     * - name
     *                   comment: 类型名称  type: varchar(255)  null: false  
     *                   key: MUL  default:   extra: 
     * - num
     *                   comment: 编号  type: varchar(64)  null: false  
     *                   key:   default:   extra: 
     * - content_type
     *                   comment: 内容类型 1=BUG;2=任务;3=需求;4=故事;5=文档;  type: tinyint(3) unsigned  null: false  
     *                   key:   default: 1  extra: 
     * - color
     *                   comment: 颜色  type: char(7)  null: false  
     *                   key:   default:   extra: 
     * - status
     *                   comment: 状态 0=禁用;1=启用;  type: tinyint(1) unsigned  null: false  
     *                   key:   default: 1  extra: 
     * - sort
     *                   comment: 排序(ASC)  type: tinyint(3) unsigned  null: false  
     *                   key:   default: 0  extra: 
     * - icon
     *                   comment: 类型图标  type: varchar(255)  null: false  
     *                   key:   default:   extra: 
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
        'company_id' => [
            self::COLUMN_NAME => '公司 ID',
        ],
        'name' => [
            self::COLUMN_NAME => '类型名称',
        ],
        'num' => [
            self::COLUMN_NAME => '编号',
        ],
        'content_type' => [
            self::COLUMN_NAME => '内容类型 1=BUG;2=任务;3=需求;4=故事;5=文档;',
        ],
        'color' => [
            self::COLUMN_NAME => '颜色',
        ],
        'status' => [
            self::COLUMN_NAME => '状态 0=禁用;1=启用;',
        ],
        'sort' => [
            self::COLUMN_NAME => '排序(ASC)',
        ],
        'icon' => [
            self::COLUMN_NAME => '类型图标',
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

    /**
     * 状态值.
     */
    #[status('禁用')]
    public const STATUS_DISABLE = 0;

    #[status('启用')]
    public const STATUS_ENABLE = 1;

    /**
     * 内容类型值.
     */
    #[content_type('BUG')]
    public const CONTENT_TYPE_BUG = 1;

    #[content_type('任务')]
    public const CONTENT_TYPE_TASK = 2;

    #[content_type('需求')]
    public const CONTENT_TYPE_PRODUCT = 3;

    #[content_type('故事')]
    public const CONTENT_TYPE_STORY = 4;

    #[content_type('文档')]
    public const CONTENT_TYPE_DOC = 5;
}
