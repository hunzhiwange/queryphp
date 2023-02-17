<?php

declare(strict_types=1);

namespace App\Domain\Entity\Project;

use Leevel\Database\Ddd\Entity;
use Leevel\Database\Ddd\Struct;

/**
 * 项目附件.
 */
final class ProjectAttachment extends Entity
{
    /**
     * Database table.
     */
    public const TABLE = 'project_attachment';

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
            'type_name' => 'bigint',
            'type_length' => 20,
        ],
    ])]
    protected ?int $id = null;

    #[Struct([
        self::COLUMN_NAME => '文件名称',
        self::COLUMN_STRUCT => [
            'type_name' => 'varchar',
            'type_length' => 100,
        ],
    ])]
    protected ?string $name = null;

    #[Struct([
        self::COLUMN_NAME => '公司 ID',
        self::COLUMN_STRUCT => [
            'type_name' => 'bigint',
            'type_length' => 20,
        ],
    ])]
    protected ?int $companyId = null;

    #[Struct([
        self::COLUMN_NAME => '项目ID',
        self::COLUMN_STRUCT => [
            'type_name' => 'int',
            'type_length' => 11,
        ],
    ])]
    protected ?int $projectId = null;

    #[Struct([
        self::COLUMN_NAME => '任务ID',
        self::COLUMN_STRUCT => [
            'type_name' => 'int',
            'type_length' => 11,
        ],
    ])]
    protected ?int $projectIssueId = null;

    #[Struct([
        self::COLUMN_NAME => '文件大小(B)',
        self::COLUMN_STRUCT => [
            'type_name' => 'int',
            'type_length' => 11,
        ],
    ])]
    protected ?int $size = null;

    #[Struct([
        self::COLUMN_NAME => '文件格式',
        self::COLUMN_STRUCT => [
            'type_name' => 'varchar',
            'type_length' => 20,
        ],
    ])]
    protected ?string $ext = null;

    #[Struct([
        self::COLUMN_NAME => '文件地址',
        self::COLUMN_STRUCT => [
            'type_name' => 'varchar',
            'type_length' => 255,
        ],
    ])]
    protected ?string $path = null;

    #[Struct([
        self::COLUMN_NAME => '下载次数',
        self::COLUMN_STRUCT => [
            'type_name' => 'int',
            'type_length' => 11,
        ],
    ])]
    protected ?int $downloadNumber = null;

    #[Struct([
        self::COLUMN_NAME => '创建时间',
        self::COLUMN_STRUCT => [
            'type_name' => 'datetime',
            'type_length' => null,
        ],
    ])]
    protected ?string $createAt = null;

    #[Struct([
        self::COLUMN_NAME => '更新时间',
        self::COLUMN_STRUCT => [
            'type_name' => 'datetime',
            'type_length' => null,
        ],
    ])]
    protected ?string $updateAt = null;

    #[Struct([
        self::COLUMN_NAME => '删除时间 0=未删除;大于0=删除时间;',
        self::SHOW_PROP_BLACK => true,
        self::COLUMN_STRUCT => [
            'type_name' => 'bigint',
            'type_length' => 20,
        ],
    ])]
    protected ?int $deleteAt = null;

    #[Struct([
        self::COLUMN_NAME => '创建账号',
        self::SHOW_PROP_BLACK => true,
        self::COLUMN_STRUCT => [
            'type_name' => 'bigint',
            'type_length' => 20,
        ],
    ])]
    protected ?int $createAccount = null;

    #[Struct([
        self::COLUMN_NAME => '更新账号',
        self::SHOW_PROP_BLACK => true,
        self::COLUMN_STRUCT => [
            'type_name' => 'bigint',
            'type_length' => 20,
        ],
    ])]
    protected ?int $updateAccount = null;

    #[Struct([
        self::COLUMN_NAME => '操作版本号',
        self::COLUMN_STRUCT => [
            'type_name' => 'bigint',
            'type_length' => 20,
        ],
    ])]
    protected ?int $version = null;
}
