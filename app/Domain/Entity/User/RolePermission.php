<?php

declare(strict_types=1);

namespace App\Domain\Entity\User;

use Leevel\Database\Ddd\Entity;
use Leevel\Database\Ddd\Struct;

/**
 * 角色权限关联.
 */
final class RolePermission extends Entity
{
    /**
     * Database table.
     */
    public const TABLE = 'role_permission';

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
            'type' => 'bigint',
            'length' => 20,
        ],
    ])]
    protected ?int $id = null;

    #[Struct([
        self::COLUMN_NAME => '角色 ID',
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'length' => 20,
        ],
    ])]
    protected ?int $roleId = null;

    #[Struct([
        self::COLUMN_NAME => '权限 ID',
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'length' => 20,
        ],
    ])]
    protected ?int $permissionId = null;

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
}
