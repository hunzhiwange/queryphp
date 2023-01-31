<?php

declare(strict_types=1);

namespace App\Domain\Entity\Project;

use Leevel\Database\Ddd\Entity;
use Leevel\Database\Ddd\GetterSetter;
use Leevel\Database\Ddd\Relation\BelongsTo;

/**
 * 项目版本.
 */
class ProjectRelease extends Entity
{
    use GetterSetter;

    /**
     * Database table.
     */
    public const TABLE = 'project_release';

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
     *                   comment: 发行名称  type: varchar(255)  null: false
     *                   key: MUL  default:   extra:
     * - sort
     *                   comment: 排序(ASC)  type: bigint(20) unsigned  null: false
     *                   key:   default: 0  extra:
     * - status
     *                   comment: 状态 0=禁用;1=启用;  type: tinyint(1) unsigned  null: false
     *                   key:   default: 1  extra:
     * - progress
     *                   comment: 进度条(最大值 10000，需要除以 100 表示实际进度)  type: int(5) unsigned  null: false
     *                   key:   default: 0  extra:
     * - project_id
     *                   comment: 项目 ID  type: bigint(20) unsigned  null: false
     *                   key:   default: 0  extra:
     * - completed
     *                   comment: 是否完成：1=未开始;2=进行中;3=延期发布;4=已发布;  type: tinyint(1) unsigned  null: false
     *                   key:   default: 1  extra:
     * - completed_date
     *                   comment: 完成时间  type: datetime  null: false
     *                   key:   default: null  extra:
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
            self::READONLY    => true,
        ],
        'company_id' => [
            self::COLUMN_NAME => '公司 ID',
        ],
        'name' => [
            self::COLUMN_NAME => '发行名称',
        ],
        'sort' => [
            self::COLUMN_NAME => '排序(ASC)',
        ],
        'status' => [
            self::COLUMN_NAME => '状态 0=禁用;1=启用;',
            self::ENUM_CLASS  => ProjectReleaseStatusEnum::class,
        ],
        'progress' => [
            self::COLUMN_NAME => '进度条(最大值 10000，需要除以 100 表示实际进度)',
        ],
        'project_id' => [
            self::COLUMN_NAME => '项目 ID',
        ],
        'completed' => [
            self::COLUMN_NAME => '是否完成：1=未开始;2=进行中;3=延期发布;4=已发布;',
            self::ENUM_CLASS  => ProjectReleaseCompletedEnum::class,
        ],
        'completed_date' => [
            self::COLUMN_NAME => '完成时间',
        ],
        'create_at' => [
            self::COLUMN_NAME => '创建时间',
        ],
        'update_at' => [
            self::COLUMN_NAME => '更新时间',
        ],
        'delete_at' => [
            self::COLUMN_NAME     => '删除时间 0=未删除;大于0=删除时间;',
            self::SHOW_PROP_BLACK => true,
        ],
        'create_account' => [
            self::COLUMN_NAME     => '创建账号',
            self::SHOW_PROP_BLACK => true,
        ],
        'update_account' => [
            self::COLUMN_NAME     => '更新账号',
            self::SHOW_PROP_BLACK => true,
        ],
        'version' => [
            self::COLUMN_NAME => '操作版本号',
        ],
        'project'      => [
            self::BELONGS_TO             => Project::class,
            self::SOURCE_KEY             => 'project_id',
            self::TARGET_KEY             => 'id',
            self::RELATION_SCOPE         => 'project',
        ],
    ]; // END STRUCT

    /**
     * Soft delete column.
     */
    public const DELETE_AT = 'delete_at';

    /**
     * 项目关联查询作用域.
     */
    protected function relationScopeProject(BelongsTo $relation): void
    {
    }
}
