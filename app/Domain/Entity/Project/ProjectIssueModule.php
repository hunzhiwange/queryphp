<?php

declare(strict_types=1);

namespace App\Domain\Entity\Project;

use Leevel\Database\Ddd\Entity;
use Leevel\Database\Ddd\GetterSetter;

/**
 * 项目问题模块关联.
 */
class ProjectIssueModule extends Entity
{
    use GetterSetter;

    /**
     * Database table.
     */
    public const TABLE = 'project_issue_module';

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
     *                      comment: ID  type: bigint(20) unsigned  null: false
     *                      key: PRI  default: null  extra: auto_increment
     * - company_id
     *                      comment: 公司 ID  type: bigint(20) unsigned  null: false
     *                      key:   default: 1  extra:
     * - project_issue_id
     *                      comment: 项目问题 ID  type: bigint(20) unsigned  null: false
     *                      key: MUL  default: 0  extra:
     * - project_module_id
     *                      comment: 项目模块 ID  type: bigint(20) unsigned  null: false
     *                      key:   default: 0  extra:
     * - create_at
     *                      comment: 创建时间  type: datetime  null: false
     *                      key:   default: CURRENT_TIMESTAMP  extra:
     * - update_at
     *                      comment: 更新时间  type: datetime  null: false
     *                      key:   default: CURRENT_TIMESTAMP  extra: on update CURRENT_TIMESTAMP
     * - delete_at
     *                      comment: 删除时间 0=未删除;大于0=删除时间;  type: bigint(20) unsigned  null: false
     *                      key:   default: 0  extra:
     * - create_account
     *                      comment: 创建账号  type: bigint(20) unsigned  null: false
     *                      key:   default: 0  extra:
     * - update_account
     *                      comment: 更新账号  type: bigint(20) unsigned  null: false
     *                      key:   default: 0  extra:
     * - version
     *                      comment: 操作版本号  type: bigint(20) unsigned  null: false
     *                      key:   default: 0  extra:
     */
    public const STRUCT = [
        'id' => [
            self::COLUMN_NAME => 'ID',
            self::READONLY => true,
        ],
        'company_id' => [
            self::COLUMN_NAME => '公司 ID',
        ],
        'project_issue_id' => [
            self::COLUMN_NAME => '项目问题 ID',
        ],
        'project_module_id' => [
            self::COLUMN_NAME => '项目模块 ID',
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
