<?php

declare(strict_types=1);

namespace App\Domain\Entity\Base;

use App\Infra\Repository\Base\App as RepositoryApp;
use Leevel\Database\Ddd\Entity;
use Leevel\Database\Ddd\Struct;

/**
 * 应用.
 */
final class App extends Entity
{
    /**
     * Database table.
     */
    public const TABLE = 'app';

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

    /**
     * 仓储.
     */
    public const REPOSITORY = RepositoryApp::class;

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
        self::COLUMN_NAME => '应用 ID',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'length' => 64,
        ],
    ])]
    protected ?string $num = null;

    #[Struct([
        self::COLUMN_NAME => '应用 KEY',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'length' => 64,
        ],
    ])]
    protected ?string $key = null;

    #[Struct([
        self::COLUMN_NAME => '应用秘钥',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'length' => 64,
        ],
    ])]
    protected ?string $secret = null;

    #[Struct([
        self::COLUMN_NAME => '状态 0=禁用;1=启用;',
        self::ENUM_CLASS => AppStatusEnum::class,
        self::COLUMN_STRUCT => [
            'type' => 'tinyint',
            'length' => 1,
        ],
    ])]
    protected ?int $status = null;

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
