<?php

declare(strict_types=1);

namespace App\User\Entity;

use App\Infra\Entity\EnabledEnum;
use App\Infra\Service\Support\ReadParams;
use Leevel\Database\Ddd\Entity;
use Leevel\Database\Ddd\EntityCollection;
use Leevel\Database\Ddd\Struct;

/**
 * 角色.
 */
final class Role extends Entity
{
    public const CONNECT = 'common';

    /**
     * Database table.
     */
    public const TABLE = 'role';

    /**
     * Database table name.
     */
    public const TABLE_NAME = '角色';

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
        'uniq_name' => [
            'field' => ['platform_id', 'name', 'delete_at'],
            'comment' => '角色名字',
        ],
        'uniq_num' => [
            'field' => ['platform_id', 'num', 'delete_at'],
            'comment' => '编号',
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
        self::COLUMN_NAME => '角色名字',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'default' => '',
            'length' => 64,
        ],
        self::COLUMN_VALIDATOR => [
            self::VALIDATOR_SCENES => 'required|chinese_alpha_num|max_length:50',
            'store' => null,
            'update' => null,
        ],
        self::META => [
            ReadParams::SEARCH_KEY_COLUMN => true,
        ],
    ])]
    protected ?string $name = null;

    #[Struct([
        self::COLUMN_NAME => '编号',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'default' => '',
            'length' => 64,
        ],
        self::COLUMN_VALIDATOR => [
            self::VALIDATOR_SCENES => 'required|alpha_dash|max_length:50',
            'store' => null,
            'update' => null,
        ],
        self::META => [
            ReadParams::SEARCH_KEY_COLUMN => true,
        ],
    ])]
    protected ?string $num = null;

    #[Struct([
        self::COLUMN_NAME => '状态',
        self::COLUMN_COMMENT => '0=禁用;1=启用;',
        self::ENUM_CLASS => EnabledEnum::class,
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

    #[Struct([
        self::MANY_MANY => Permission::class,
        self::MIDDLE_ENTITY => RolePermission::class,
        self::SOURCE_KEY => 'id',
        self::TARGET_KEY => 'id',
        self::MIDDLE_SOURCE_KEY => 'role_id',
        self::MIDDLE_TARGET_KEY => 'permission_id',
    ])]
    protected ?EntityCollection $permission = null;
}
