<?php

declare(strict_types=1);

namespace App\Domain\Entity\User;

use App\Infra\Repository\User\Permission as RepositoryPermission;
use Leevel\Database\Ddd\Entity;
use Leevel\Database\Ddd\EntityCollection;
use Leevel\Database\Ddd\Relation\ManyMany;
use Leevel\Database\Ddd\Struct;

/**
 * 权限.
 */
final class Permission extends Entity
{
    /**
     * Database table.
     */
    public const TABLE = 'permission';

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
    public const REPOSITORY = RepositoryPermission::class;

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
        self::COLUMN_NAME => '父级 ID',
        self::COLUMN_STRUCT => [
            'type_name' => 'bigint',
            'type_length' => 20,
        ],
    ])]
    protected ?int $pid = null;

    #[Struct([
        self::COLUMN_NAME => '权限名字',
        self::COLUMN_STRUCT => [
            'type_name' => 'varchar',
            'type_length' => 64,
        ],
    ])]
    protected ?string $name = null;

    #[Struct([
        self::COLUMN_NAME => '编号',
        self::COLUMN_STRUCT => [
            'type_name' => 'varchar',
            'type_length' => 64,
        ],
    ])]
    protected ?string $num = null;

    #[Struct([
        self::COLUMN_NAME => '状态 0=禁用;1=启用;',
        self::ENUM_CLASS => PermissionStatusEnum::class,
        self::COLUMN_STRUCT => [
            'type_name' => 'tinyint',
            'type_length' => 1,
        ],
    ])]
    protected ?int $status = null;

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

    #[Struct([
        self::MANY_MANY => Resource::class,
        self::MIDDLE_ENTITY => PermissionResource::class,
        self::SOURCE_KEY => 'id',
        self::TARGET_KEY => 'id',
        self::MIDDLE_SOURCE_KEY => 'permission_id',
        self::MIDDLE_TARGET_KEY => 'resource_id',
        self::RELATION_SCOPE => 'resource',
    ])]
    protected ?EntityCollection $resource = null;

    /**
     * 资源关联查询作用域.
     */
    protected function relationScopeResource(ManyMany $relation): void
    {
        $relation
            ->where('status', ResourceStatusEnum::ENABLE->value)
            ->setColumns(['id', 'name', 'num', 'status'])
        ;
    }
}
