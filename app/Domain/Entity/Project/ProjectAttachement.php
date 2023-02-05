<?php

declare(strict_types=1);

namespace App\Domain\Entity\Project;

use Leevel\Database\Ddd\Entity;
use Leevel\Database\Ddd\GetterSetter;

/**
 * 项目附件.
 */
class ProjectAttachement extends Entity
{
    use GetterSetter;

    /**
     * Database table.
     */
    public const TABLE = 'project_attachement';

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
     * - name
     *                     comment: 文件名称  type: varchar(100)  null: false
     *                     key:   default:   extra:
     * - company_id
     *                     comment: 公司 ID  type: bigint(20) unsigned  null: false
     *                     key: MUL  default: 1  extra:
     * - project_id
     *                     comment: 项目ID  type: int(11) unsigned  null: false
     *                     key:   default: 0  extra:
     * - project_issue_id
     *                     comment: 任务ID  type: int(11) unsigned  null: false
     *                     key:   default: 0  extra:
     * - size
     *                     comment: 文件大小(B)  type: int(11) unsigned  null: false
     *                     key:   default: 0  extra:
     * - ext
     *                     comment: 文件格式  type: varchar(20)  null: false
     *                     key:   default:   extra:
     * - path
     *                     comment: 文件地址  type: varchar(255)  null: false
     *                     key:   default:   extra:
     * - download_number
     *                     comment: 下载次数  type: int(11) unsigned  null: false
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
     *                     key:   default: 1  extra:
     */
    public const STRUCT = [
        'id' => [
            self::COLUMN_NAME => 'ID',
            self::READONLY => true,
        ],
        'name' => [
            self::COLUMN_NAME => '文件名称',
        ],
        'company_id' => [
            self::COLUMN_NAME => '公司 ID',
        ],
        'project_id' => [
            self::COLUMN_NAME => '项目ID',
        ],
        'project_issue_id' => [
            self::COLUMN_NAME => '任务ID',
        ],
        'size' => [
            self::COLUMN_NAME => '文件大小(B)',
        ],
        'ext' => [
            self::COLUMN_NAME => '文件格式',
        ],
        'path' => [
            self::COLUMN_NAME => '文件地址',
        ],
        'download_number' => [
            self::COLUMN_NAME => '下载次数',
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
    ]; // END STRUCT

    /**
     * Soft delete column.
     */
    public const DELETE_AT = 'delete_at';
}
