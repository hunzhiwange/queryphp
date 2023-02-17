<?php

declare(strict_types=1);

namespace App\Domain\Entity\Project;

use App\Infra\Repository\Project\ProjectIssue as ProjectProjectIssue;
use Leevel\Database\Ddd\Entity;
use Leevel\Database\Ddd\EntityCollection;
use Leevel\Database\Ddd\Relation\HasOne;
use Leevel\Database\Ddd\Relation\ManyMany;
use Leevel\Database\Ddd\Struct;

/**
 * 项目问题.
 */
final class ProjectIssue extends Entity
{
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
     * Soft delete column.
     */
    public const DELETE_AT = 'delete_at';

    /**
     * 仓储.
     */
    public const REPOSITORY = ProjectProjectIssue::class;

    /**
     * 排序间隔.
     */
    public const SORT_INTERVAL = 65536;

    #[Struct([
        self::COLUMN_NAME => 'ID',
        self::READONLY => true,
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'length' => 20,
        ],
    ])]
    protected ?int $id = null;

    #[Struct([
        self::COLUMN_NAME => '标题',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'length' => 255,
        ],
    ])]
    protected ?string $title = null;

    #[Struct([
        self::COLUMN_NAME => '子标题',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'length' => 255,
        ],
    ])]
    protected ?string $subTitle = null;

    #[Struct([
        self::COLUMN_NAME => '编号: 例如 ISSUE-1101',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'length' => 50,
        ],
    ])]
    protected ?string $num = null;

    #[Struct([
        self::COLUMN_NAME => '公司 ID',
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'length' => 20,
        ],
    ])]
    protected ?int $companyId = null;

    #[Struct([
        self::COLUMN_NAME => '项目ID',
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'length' => 20,
        ],
    ])]
    protected ?int $projectId = null;

    #[Struct([
        self::COLUMN_NAME => '项目分类 ID',
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'length' => 20,
        ],
    ])]
    protected ?int $projectLabelId = null;

    #[Struct([
        self::COLUMN_NAME => '项目问题类型 ID',
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'length' => 20,
        ],
    ])]
    protected ?int $projectTypeId = null;

    #[Struct([
        self::COLUMN_NAME => '负责人用户 ID',
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'length' => 20,
        ],
    ])]
    protected ?int $ownerUserId = null;

    #[Struct([
        self::COLUMN_NAME => '项目日志 ID',
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'length' => 20,
        ],
    ])]
    protected ?int $projectLogId = null;

    #[Struct([
        self::COLUMN_NAME => '描述',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'length' => 500,
        ],
    ])]
    protected ?string $desc = null;

    #[Struct([
        self::COLUMN_NAME => '优先级别：1~5',
        self::ENUM_CLASS => ProjectIssueLevelEnum::class,
        self::COLUMN_STRUCT => [
            'type' => 'tinyint',
            'length' => 1,
        ],
    ])]
    protected ?int $level = null;

    #[Struct([
        self::COLUMN_NAME => '是否完成：1=未完成;2=已完成;',
        self::ENUM_CLASS => ProjectIssueCompletedEnum::class,
        self::COLUMN_STRUCT => [
            'type' => 'tinyint',
            'length' => 1,
        ],
    ])]
    protected ?int $completed = null;

    #[Struct([
        self::COLUMN_NAME => '完成时间',
        self::COLUMN_STRUCT => [
            'type' => 'datetime',
            'length' => null,
        ],
    ])]
    protected ?string $completedDate = null;

    #[Struct([
        self::COLUMN_NAME => '子任务列表',
        self::COLUMN_STRUCT => [
            'type' => 'text',
            'length' => null,
        ],
    ])]
    protected ?string $subTask = null;

    #[Struct([
        self::COLUMN_NAME => '关注人列表',
        self::COLUMN_STRUCT => [
            'type' => 'text',
            'length' => null,
        ],
    ])]
    protected ?string $follower = null;

    #[Struct([
        self::COLUMN_NAME => '附件数量',
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'length' => 20,
        ],
    ])]
    protected ?int $fileNumber = null;

    #[Struct([
        self::COLUMN_NAME => '计划开始时间',
        self::COLUMN_STRUCT => [
            'type' => 'datetime',
            'length' => null,
        ],
    ])]
    protected ?string $startDate = null;

    #[Struct([
        self::COLUMN_NAME => '计划结束时间',
        self::COLUMN_STRUCT => [
            'type' => 'datetime',
            'length' => null,
        ],
    ])]
    protected ?string $endDate = null;

    #[Struct([
        self::COLUMN_NAME => '是否归档：1=未归档;2=已归档;',
        self::COLUMN_STRUCT => [
            'type' => 'tinyint',
            'length' => 1,
        ],
    ])]
    protected ?int $archived = null;

    #[Struct([
        self::COLUMN_NAME => '归档时间',
        self::COLUMN_STRUCT => [
            'type' => 'datetime',
            'length' => null,
        ],
    ])]
    protected ?string $archivedDate = null;

    #[Struct([
        self::COLUMN_NAME => '排序(DESC)',
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'length' => 20,
        ],
    ])]
    protected ?int $sort = null;

    #[Struct([
        self::COLUMN_NAME => '会员自己的排序(DESC)',
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'length' => 20,
        ],
    ])]
    protected ?int $userSort = null;

    #[Struct([
        self::COLUMN_NAME => '创建时间',
        self::COLUMN_STRUCT => [
            'type' => 'datetime',
            'length' => null,
        ],
    ])]
    protected ?string $createAt = null;

    #[Struct([
        self::COLUMN_NAME => '更新时间',
        self::COLUMN_STRUCT => [
            'type' => 'datetime',
            'length' => null,
        ],
    ])]
    protected ?string $updateAt = null;

    #[Struct([
        self::COLUMN_NAME => '删除时间 0=未删除;大于0=删除时间;',
        self::SHOW_PROP_BLACK => true,
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'length' => 20,
        ],
    ])]
    protected ?int $deleteAt = null;

    #[Struct([
        self::COLUMN_NAME => '创建账号',
        self::SHOW_PROP_BLACK => true,
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'length' => 20,
        ],
    ])]
    protected ?int $createAccount = null;

    #[Struct([
        self::COLUMN_NAME => '更新账号',
        self::SHOW_PROP_BLACK => true,
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'length' => 20,
        ],
    ])]
    protected ?int $updateAccount = null;

    #[Struct([
        self::COLUMN_NAME => '操作版本号',
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'length' => 20,
        ],
    ])]
    protected ?int $version = null;

    #[Struct([
        self::BELONGS_TO => Project::class,
        self::SOURCE_KEY => 'project_id',
        self::TARGET_KEY => 'id',
    ])]
    protected ?Project $project = null;

    #[Struct([
        self::BELONGS_TO => ProjectLabel::class,
        self::SOURCE_KEY => 'project_label_id',
        self::TARGET_KEY => 'id',
    ])]
    protected ?ProjectLabel $projectLabel = null;

    #[Struct([
        self::HAS_ONE => ProjectType::class,
        self::SOURCE_KEY => 'project_type_id',
        self::TARGET_KEY => 'id',
        self::RELATION_SCOPE => 'projectType',
    ])]
    protected ?ProjectType $projectType = null;

    #[Struct([
        self::MANY_MANY => ProjectRelease::class,
        self::MIDDLE_ENTITY => ProjectIssueRelease::class,
        self::SOURCE_KEY => 'id',
        self::TARGET_KEY => 'id',
        self::MIDDLE_SOURCE_KEY => 'project_issue_id',
        self::MIDDLE_TARGET_KEY => 'project_release_id',
        self::RELATION_SCOPE => 'projectReleases',
    ])]
    protected ?EntityCollection $projectReleases = null;

    #[Struct([
        self::MANY_MANY => ProjectTag::class,
        self::MIDDLE_ENTITY => ProjectIssueTag::class,
        self::SOURCE_KEY => 'id',
        self::TARGET_KEY => 'id',
        self::MIDDLE_SOURCE_KEY => 'project_issue_id',
        self::MIDDLE_TARGET_KEY => 'project_tag_id',
        self::RELATION_SCOPE => 'projectTags',
    ])]
    protected ?EntityCollection $projectTags = null;

    #[Struct([
        self::MANY_MANY => ProjectModule::class,
        self::MIDDLE_ENTITY => ProjectIssueModule::class,
        self::SOURCE_KEY => 'id',
        self::TARGET_KEY => 'id',
        self::MIDDLE_SOURCE_KEY => 'project_issue_id',
        self::MIDDLE_TARGET_KEY => 'project_module_id',
        self::RELATION_SCOPE => 'projectModules',
    ])]
    protected ?EntityCollection $projectModules = null;

    #[Struct([
        self::HAS_ONE => ProjectContent::class,
        self::SOURCE_KEY => 'id',
        self::TARGET_KEY => 'project_issue_id',
    ])]
    protected ?ProjectContent $projectContent = null;

    public static function repository(?Entity $entity = null): ProjectProjectIssue
    {
        return parent::repository($entity);
    }

    /**
     * 问题类型关联查询作用域.
     */
    protected function relationScopeProjectType(HasOne $relation): void
    {
    }

    /**
     * 问题发行版关联查询作用域.
     */
    protected function relationScopeProjectReleases(ManyMany $relation): void
    {
    }

    /**
     * 问题标签关联查询作用域.
     */
    protected function relationScopeProjectTags(ManyMany $relation): void
    {
    }

    /**
     * 问题模块关联查询作用域.
     */
    protected function relationScopeProjectModules(ManyMany $relation): void
    {
    }
}
