<?php

declare(strict_types=1);

namespace App\Domain\Entity\Project;

use Leevel\Database\Ddd\Entity;
use Leevel\Database\Ddd\Relation\BelongsTo;
use Leevel\Database\Ddd\Struct;

/**
 * 项目发行版.
 */
final class ProjectRelease extends Entity
{
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
     * Soft delete column.
     */
    public const DELETE_AT = 'delete_at';

    #[Struct([
        self::COLUMN_NAME => 'ID',
        self::READONLY => true,
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'default' => null,
        ],
    ])]
    protected ?int $id = null;

    #[Struct([
        self::COLUMN_NAME => '公司 ID',
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'default' => 1,
        ],
    ])]
    protected ?int $companyId = null;

    #[Struct([
        self::COLUMN_NAME => '发行名称',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'default' => '',
            'length' => 255,
        ],
    ])]
    protected ?string $name = null;

    #[Struct([
        self::COLUMN_NAME => '排序(ASC)',
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'default' => 0,
        ],
    ])]
    protected ?int $sort = null;

    #[Struct([
        self::COLUMN_NAME => '状态 0=禁用;1=启用;',
        self::ENUM_CLASS => ProjectReleaseStatusEnum::class,
        self::COLUMN_STRUCT => [
            'type' => 'tinyint',
            'default' => 1,
        ],
    ])]
    protected ?int $status = null;

    #[Struct([
        self::COLUMN_NAME => '进度条(最大值 10000，需要除以 100 表示实际进度)',
        self::COLUMN_STRUCT => [
            'type' => 'int',
            'default' => 0,
        ],
    ])]
    protected ?int $progress = null;

    #[Struct([
        self::COLUMN_NAME => '项目 ID',
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'default' => 0,
        ],
    ])]
    protected ?int $projectId = null;

    #[Struct([
        self::COLUMN_NAME => '是否完成：1=未开始;2=进行中;3=延期发布;4=已发布;',
        self::COLUMN_STRUCT => [
            'type' => 'tinyint',
            'default' => 1,
        ],
    ])]
    protected ?int $completed = null;

    #[Struct([
        self::COLUMN_NAME => '完成时间',
        self::COLUMN_STRUCT => [
            'type' => 'datetime',
            'default' => null,
        ],
    ])]
    protected ?string $completedDate = null;

    #[Struct([
        self::COLUMN_NAME => '创建时间',
        self::COLUMN_STRUCT => [
            'type' => 'datetime',
            'default' => 'CURRENT_TIMESTAMP',
        ],
    ])]
    protected ?string $createAt = null;

    #[Struct([
        self::COLUMN_NAME => '更新时间',
        self::COLUMN_STRUCT => [
            'type' => 'datetime',
            'default' => 'CURRENT_TIMESTAMP',
        ],
    ])]
    protected ?string $updateAt = null;

    #[Struct([
        self::COLUMN_NAME => '删除时间 0=未删除;大于0=删除时间;',
        self::SHOW_PROP_BLACK => true,
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'default' => 0,
        ],
    ])]
    protected ?int $deleteAt = null;

    #[Struct([
        self::COLUMN_NAME => '创建账号',
        self::SHOW_PROP_BLACK => true,
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'default' => 0,
        ],
    ])]
    protected ?int $createAccount = null;

    #[Struct([
        self::COLUMN_NAME => '更新账号',
        self::SHOW_PROP_BLACK => true,
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'default' => 0,
        ],
    ])]
    protected ?int $updateAccount = null;

    #[Struct([
        self::COLUMN_NAME => '操作版本号',
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'default' => 0,
        ],
    ])]
    protected ?int $version = null;

    #[Struct([
        self::BELONGS_TO => Project::class,
        self::SOURCE_KEY => 'project_id',
        self::TARGET_KEY => 'id',
        self::RELATION_SCOPE => 'project',
    ])]
    protected ?Project $project = null;

    /**
     * 项目关联查询作用域.
     */
    protected function relationScopeProject(BelongsTo $relation): void
    {
    }
}
