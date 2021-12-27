<?php

declare(strict_types=1);

namespace App\Domain\Entity\Project;

use App\Infra\Repository\Project\ProjectIssue as ProjectProjectIssue;
use Leevel\Database\Ddd\Entity;
use Leevel\Database\Ddd\GetterSetter;
use Leevel\Database\Ddd\Relation\HasOne;
use Leevel\Database\Ddd\Relation\ManyMany;

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
     * - title
     *                     comment: 标题  type: varchar(255)  null: false  
     *                     key:   default:   extra: 
     * - num
     *                     comment: 编号: 例如 ISSUE-1101  type: varchar(50)  null: false  
     *                     key:   default:   extra: 
     * - company_id
     *                     comment: 公司 ID  type: bigint(20) unsigned  null: false  
     *                     key: MUL  default: 1  extra: 
     * - project_id
     *                     comment: 项目ID  type: bigint(20) unsigned  null: false  
     *                     key:   default: 0  extra: 
     * - project_label_id
     *                     comment: 项目分类 ID  type: bigint(20) unsigned  null: false  
     *                     key:   default: 0  extra: 
     * - project_type_id
     *                     comment: 项目问题类型 ID  type: bigint(20) unsigned  null: false  
     *                     key:   default: 0  extra: 
     * - owner_user_id
     *                     comment: 负责人用户 ID  type: bigint(20) unsigned  null: false  
     *                     key:   default: 0  extra: 
     * - project_log_id
     *                     comment: 项目日志 ID  type: bigint(20) unsigned  null: false  
     *                     key:   default: 0  extra: 
     * - desc
     *                     comment: 描述  type: varchar(500)  null: false  
     *                     key:   default:   extra: 
     * - level
     *                     comment: 优先级别：1~4  type: tinyint(1) unsigned  null: false  
     *                     key:   default: 1  extra: 
     * - completed
     *                     comment: 是否完成：1=未完成;2=已完成;  type: tinyint(1) unsigned  null: false  
     *                     key:   default: 1  extra: 
     * - completed_date
     *                     comment: 完成时间  type: datetime  null: false  
     *                     key:   default: null  extra: 
     * - sub_task
     *                     comment: 子任务列表  type: text  null: false  
     *                     key:   default: null  extra: 
     * - follower
     *                     comment: 关注人列表  type: text  null: false  
     *                     key:   default: null  extra: 
     * - file_number
     *                     comment: 附件数量  type: bigint(20) unsigned  null: false  
     *                     key:   default: 0  extra: 
     * - start_date
     *                     comment: 计划开始时间  type: datetime  null: false  
     *                     key:   default: null  extra: 
     * - end_date
     *                     comment: 计划结束时间  type: datetime  null: false  
     *                     key:   default: null  extra: 
     * - archived
     *                     comment: 是否归档：1=未归档;2=已归档;  type: tinyint(1) unsigned  null: false  
     *                     key:   default: 1  extra: 
     * - archived_date
     *                     comment: 归档时间  type: datetime  null: false  
     *                     key:   default: null  extra: 
     * - sort
     *                     comment: 排序(DESC)  type: bigint(20) unsigned  null: false  
     *                     key:   default: 0  extra: 
     * - user_sort
     *                     comment: 会员自己的排序(DESC)  type: bigint(20) unsigned  null: false  
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
        'title' => [
            self::COLUMN_NAME => '标题',
        ],
        'num' => [
            self::COLUMN_NAME => '编号: 例如 ISSUE-1101',
        ],
        'company_id' => [
            self::COLUMN_NAME => '公司 ID',
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
        'project_log_id' => [
            self::COLUMN_NAME => '项目日志 ID',
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
            self::COLUMN_NAME => '完成时间',
        ],
        'sub_task' => [
            self::COLUMN_NAME => '子任务列表',
        ],
        'follower' => [
            self::COLUMN_NAME => '关注人列表',
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
            self::COLUMN_NAME => '是否归档：1=未归档;2=已归档;',
        ],
        'archived_date' => [
            self::COLUMN_NAME => '归档时间',
        ],
        'sort' => [
            self::COLUMN_NAME => '排序(DESC)',
        ],
        'user_sort' => [
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
        'project_type'      => [
            self::HAS_ONE                => ProjectType::class,
            self::SOURCE_KEY             => 'project_type_id',
            self::TARGET_KEY             => 'id',
            self::RELATION_SCOPE         => 'projectType',
        ],
        'project_releases'      => [
            self::MANY_MANY              => ProjectRelease::class,
            self::MIDDLE_ENTITY          => ProjectIssueRelease::class,
            self::SOURCE_KEY             => 'id',
            self::TARGET_KEY             => 'id',
            self::MIDDLE_SOURCE_KEY      => 'project_issue_id',
            self::MIDDLE_TARGET_KEY      => 'project_release_id',
            self::RELATION_SCOPE         => 'projectReleases',
        ],
        'project_tags'      => [
            self::MANY_MANY              => ProjectTag::class,
            self::MIDDLE_ENTITY          => ProjectIssueTag::class,
            self::SOURCE_KEY             => 'id',
            self::TARGET_KEY             => 'id',
            self::MIDDLE_SOURCE_KEY      => 'project_issue_id',
            self::MIDDLE_TARGET_KEY      => 'project_tag_id',
            self::RELATION_SCOPE         => 'projectTags',
        ],
        'project_modules'      => [
            self::MANY_MANY              => ProjectModule::class,
            self::MIDDLE_ENTITY          => ProjectIssueModule::class,
            self::SOURCE_KEY             => 'id',
            self::TARGET_KEY             => 'id',
            self::MIDDLE_SOURCE_KEY      => 'project_issue_id',
            self::MIDDLE_TARGET_KEY      => 'project_module_id',
            self::RELATION_SCOPE         => 'projectModules',
        ],
    ]; // END STRUCT

    /**
     * Soft delete column.
     */
    public const DELETE_AT = 'delete_at';

    /**
     * 仓储.
     */
    public const REPOSITORY = ProjectProjectIssue::class;

    /**
     * 是否完成.
     */
    #[completed('未完成')]
    public const COMPLETED_FALSE = 1;

    #[completed('已完成')]
    public const COMPLETED_TRUE = 2;

    /**
     * 排序间隔.
     */
    public const SORT_INTERVAL = 65536;

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
