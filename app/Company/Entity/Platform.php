<?php

declare(strict_types=1);

namespace App\Company\Entity;

use Leevel\Database\Ddd\Entity;
use Leevel\Database\Ddd\Struct;

/**
 * 平台.
 */
final class Platform extends Entity
{
    /**
     * Database table.
     */
    public const TABLE = 'platform';

    /**
     * Database table name.
     */
    public const TABLE_NAME = '平台';

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
        'uniq_platform_id' => [
            'field' => ['platform_id'],
            'comment' => '平台编号',
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
        self::COLUMN_NAME => '平台ID',
        self::READONLY => true,
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'default' => null,
        ],
    ])]
    protected ?int $id = null;

    #[Struct([
        self::COLUMN_NAME => '平台编号',
        self::COLUMN_COMMENT => '自增ID+3位数据库+2位表名',
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'default' => 0,
        ],
    ])]
    protected ?int $platformId = null;

    #[Struct([
        self::COLUMN_NAME => '编号',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'default' => '',
            'length' => 30,
        ],
    ])]
    protected ?string $num = null;

    #[Struct([
        self::COLUMN_NAME => '名称',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'default' => '',
            'length' => 50,
        ],
    ])]
    protected ?string $name = null;

    #[Struct([
        self::COLUMN_NAME => '平台全称',
        self::COLUMN_STRUCT => [
            'type' => 'char',
            'default' => '',
            'length' => 100,
        ],
    ])]
    protected ?string $fullName = null;

    #[Struct([
        self::COLUMN_NAME => '状态',
        self::COLUMN_COMMENT => '0=禁用;1=启用;',
        self::COLUMN_STRUCT => [
            'type' => 'tinyint',
            'default' => 1,
        ],
    ])]
    protected ?int $status = null;

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
}
