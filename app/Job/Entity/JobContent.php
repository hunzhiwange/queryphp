<?php

declare(strict_types=1);

namespace App\Job\Entity;

use Leevel\Database\Ddd\Entity;
use Leevel\Database\Ddd\Struct;

/**
 * 任务管理内容.
 */
final class JobContent extends Entity
{
    /**
     * Database table.
     */
    public const TABLE = 'job_content';

    /**
     * Database table name.
     */
    public const TABLE_NAME = '任务管理内容';

    /**
     * Primary key.
     */
    public const ID = 'id';

    /**
     * Unique Index.
     */
    public const UNIQUE_INDEX = [
        'PRIMARY' => [
            'field' => ['id'],
            'comment' => 'ID',
        ],
    ];

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
        self::COLUMN_NAME => '平台ID',
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'default' => 0,
        ],
    ])]
    protected ?int $platformId = null;

    #[Struct([
        self::COLUMN_NAME => '公司ID',
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'default' => 0,
        ],
    ])]
    protected ?int $companyId = null;

    #[Struct([
        self::COLUMN_NAME => '内容',
        self::COLUMN_STRUCT => [
            'type' => 'mediumtext',
            'default' => null,
        ],
    ])]
    protected ?string $content = null;

    #[Struct([
        self::COLUMN_NAME => '任务ID',
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'default' => 0,
        ],
    ])]
    protected ?int $jobId = null;

    #[Struct([
        self::COLUMN_NAME => '创建时间',
        self::COLUMN_STRUCT => [
            'type' => 'datetime',
            'default' => 'CURRENT_TIMESTAMP',
        ],
    ])]
    protected ?string $createAt = null;

    #[Struct([
        self::COLUMN_NAME => '删除时间',
        self::COLUMN_COMMENT => '0=未删除;大于0=删除时间;',
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
        self::COLUMN_NAME => '操作版本号',
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'default' => 0,
        ],
    ])]
    protected ?int $version = null;
}
