<?php

declare(strict_types=1);

namespace App\Print\Entity;

use App\Infra\Entity\YesEnum;
use App\Infra\Service\Support\ReadParams;
use Leevel\Database\Ddd\Entity;
use Leevel\Database\Ddd\Struct;

/**
 * 打印模板.
 */
final class PrintTemplate extends Entity
{
    /**
     * Database table.
     */
    public const TABLE = 'print_template';

    /**
     * Database table name.
     */
    public const TABLE_NAME = '打印模板';

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
        self::COLUMN_NAME => '模板名称',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'default' => '',
            'length' => 50,
        ],
        self::COLUMN_VALIDATOR => [
            self::VALIDATOR_SCENES => [
                'max_length:50',
            ],
            'store' => null,
            'update' => null,
        ],
        self::META => [
            ReadParams::SEARCH_KEY_COLUMN => true,
        ],
    ])]
    protected ?string $name = null;

    #[Struct([
        self::COLUMN_NAME => '是否为默认模板',
        self::COLUMN_COMMENT => '0=否;1=是;',
        self::ENUM_CLASS => YesEnum::class,
        self::COLUMN_STRUCT => [
            'type' => 'tinyint',
            'default' => 0,
        ],
    ])]
    protected ?int $isDefault = null;

    #[Struct([
        self::COLUMN_NAME => '模板类型',
        self::READONLY => true,
        self::ENUM_CLASS => PrintTemplateEnum::class,
        self::COLUMN_STRUCT => [
            'type' => 'tinyint',
            'default' => 0,
        ],
    ])]
    protected ?int $type = null;

    #[Struct([
        self::COLUMN_NAME => '备注',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'default' => '',
            'length' => 50,
        ],
        self::COLUMN_VALIDATOR => [
            self::VALIDATOR_SCENES => [
                'max_length:50',
            ],
            'store' => null,
            'update' => null,
        ],
        self::META => [
            ReadParams::SEARCH_KEY_COLUMN => true,
        ],
    ])]
    protected ?string $remark = null;

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
        self::COLUMN_NAME => '内容',
        self::COLUMN_STRUCT => [
            'type' => 'text',
            'default' => null,
        ],
        self::VIRTUAL_COLUMN => true,
    ])]
    protected ?string $content = null;

    #[Struct([
        self::HAS_ONE => PrintTemplateContent::class,
        self::SOURCE_KEY => 'id',
        self::TARGET_KEY => 'template_id',
    ])]
    protected ?PrintTemplateContent $printTemplateContent = null;

    public function beforeCreateEvent(): void
    {
        // 保存主表的时候，初始化内容表
        api_ql_store(PrintTemplateContent::class, [
            'template_id' => $this->id,
            'content' => $this->content ?? '',
        ]);
    }
}
