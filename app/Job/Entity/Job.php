<?php

declare(strict_types=1);

namespace App\Job\Entity;

use Leevel\Database\Ddd\Entity;
use Leevel\Database\Ddd\Struct;

/**
 * 任务管理.
 */
final class Job extends Entity
{
    /**
     * Database table.
     */
    public const TABLE = 'job';

    /**
     * Database table name.
     */
    public const TABLE_NAME = '任务管理';

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
        self::COLUMN_NAME => '任务名称',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'default' => '',
            'length' => 200,
        ],
    ])]
    protected ?string $name = null;

    #[Struct([
        self::COLUMN_NAME => '总条数',
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'default' => 0,
        ],
    ])]
    protected ?int $total = null;

    #[Struct([
        self::COLUMN_NAME => '成功条数',
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'default' => 0,
        ],
    ])]
    protected ?int $success = null;

    #[Struct([
        self::COLUMN_NAME => '失败条数',
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'default' => 0,
        ],
    ])]
    protected ?int $fail = null;

    #[Struct([
        self::COLUMN_NAME => '类型',
        self::ENUM_CLASS => JobTypeEnum::class,
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'default' => 0,
        ],
    ])]
    protected ?int $type = null;

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

    #[Struct([
        self::COLUMN_NAME => '处理进度',
        self::COLUMN_COMMENT => '0=待处理;1=处理成功;2=处理失败;',
        self::ENUM_CLASS => JobProcessEnum::class,
        self::COLUMN_STRUCT => [
            'type' => 'tinyint',
            'default' => 0,
        ],
    ])]
    protected ?int $process = null;

    #[Struct([
        self::COLUMN_NAME => '错误消息',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'default' => '',
            'length' => 255,
        ],
    ])]
    protected ?string $error = null;

    #[Struct([
        self::COLUMN_NAME => '消费者',
        self::COLUMN_STRUCT => [
            'type' => 'tinyint',
            'default' => 0,
        ],
    ])]
    protected ?int $customer = null;

    #[Struct([
        self::COLUMN_NAME => '重试次数',
        self::COLUMN_STRUCT => [
            'type' => 'tinyint',
            'default' => 0,
        ],
    ])]
    protected ?int $retry = null;

    #[Struct([
        self::COLUMN_NAME => '内容',
        self::COLUMN_STRUCT => [
            'type' => 'mediumtext',
            'default' => null,
        ],
        self::VIRTUAL_COLUMN => true,
    ])]
    protected ?string $content = null;

    #[Struct([
        self::HAS_ONE => JobContent::class,
        self::SOURCE_KEY => 'id',
        self::TARGET_KEY => 'job_id',
    ])]
    protected ?JobContent $jobContent = null;

    public function beforeCreateEvent(): void
    {
        $content = $this->content ?: '[]';
        $contentArr = json_decode($content, true, 512, JSON_THROW_ON_ERROR);

        // 更新任务总记录数
        $this->withProp('total', \count($contentArr));

        // 保存主表的时候，初始化内容表
        api_ql_store(JobContent::class, [
            'job_id' => $this->id,
            'content' => $content,
        ]);
    }
}
