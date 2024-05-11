<?php

declare(strict_types=1);

namespace App\User\Entity;

use Leevel\Database\Ddd\Entity;
use Leevel\Database\Ddd\Struct;

/**
 * 权限资源关联.
 */
final class PermissionResource extends Entity
{
    public const string CONNECT = 'common';

    /**
     * Database table.
     */
    public const string TABLE = 'permission_resource';

    /**
     * Database table name.
     */
    public const string TABLE_NAME = '权限资源关联';

    /**
     * Primary key.
     */
    public const string ID = 'id';

    /**
     * Unique Index.
     */
    public const array UNIQUE_INDEX = [
        'PRIMARY' => [
            'field' => ['id'],
            'comment' => 'ID',
        ],
        'uniq_permission_resource' => [
            'field' => ['platform_id', 'permission_id', 'resource_id', 'delete_at'],
            'comment' => '权限资源关联',
        ],
    ];

    /**
     * Auto increment.
     */
    public const string AUTO = 'id';

    /**
     * Soft delete column.
     */
    public const string DELETE_AT = 'delete_at';

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
        self::COLUMN_NAME => '权限ID',
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'default' => 0,
        ],
    ])]
    protected ?int $permissionId = null;

    #[Struct([
        self::COLUMN_NAME => '资源ID',
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'default' => 0,
        ],
    ])]
    protected ?int $resourceId = null;

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
