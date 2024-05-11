<?php

declare(strict_types=1);

namespace App\Base\Entity;

use Leevel\Database\Ddd\Entity;
use Leevel\Database\Ddd\Struct;

/**
 * 常用搜索.
 */
final class SearchPlan extends Entity
{
    /**
     * Database table.
     */
<<<<<<< HEAD
    public const string TABLE = 'search_plan';
=======
    public const string TABLE = 'search_plan';
>>>>>>> master

    /**
     * Database table name.
     */
    public const string TABLE_NAME = '常用搜索';

    /**
     * Primary key.
     */
    public const string ID = 'id';

    /**
     * Unique Index.
     */
<<<<<<< HEAD
    public const array UNIQUE_INDEX = [
=======
    public const array UNIQUE_INDEX = [
>>>>>>> master
        'PRIMARY' => [
            'field' => ['id'],
            'comment' => 'ID',
        ],
    ];

    /**
     * Auto increment.
     */
<<<<<<< HEAD
    public const string AUTO = 'id';
=======
    public const string AUTO = 'id';
>>>>>>> master

    /**
     * Soft delete column.
     */
<<<<<<< HEAD
    public const string DELETE_AT = 'delete_at';
=======
    public const string DELETE_AT = 'delete_at';
>>>>>>> master

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
        self::COLUMN_NAME => '搜索名称',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'default' => '',
            'length' => 50,
        ],
    ])]
    protected ?string $name = null;

    #[Struct([
        self::COLUMN_NAME => '是否为默认搜索',
        self::COLUMN_COMMENT => '0=否;1=是;',
        self::COLUMN_STRUCT => [
            'type' => 'tinyint',
            'default' => 0,
        ],
    ])]
    protected ?int $isDefault = null;

    #[Struct([
        self::COLUMN_NAME => '计划',
        self::COLUMN_STRUCT => [
            'type' => 'text',
            'default' => null,
        ],
    ])]
    protected ?string $plan = null;

    #[Struct([
        self::COLUMN_NAME => '来源类型',
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'default' => 0,
        ],
    ])]
    protected ?int $sourceType = null;

    #[Struct([
        self::COLUMN_NAME => '备注',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'default' => '',
            'length' => 50,
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
        self::COLUMN_NAME => '类型',
        self::COLUMN_COMMENT => '1=搜索条件;2=列配置;',
        self::ENUM_CLASS => SearchPlanTypeEnum::class,
        self::COLUMN_STRUCT => [
            'type' => 'tinyint',
            'default' => 1,
        ],
    ])]
    protected ?int $type = null;
}
