<?php

declare(strict_types=1);

namespace App\Domain\Entity\Project;

use Leevel\Database\Ddd\Entity;
use Leevel\Database\Ddd\Struct;

/**
 * 项目用户.
 */
final class ProjectUser extends Entity
{
    /**
     * Database table.
     */
    public const TABLE = 'project_user';

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
            'type_name' => 'bigint',
            'type_length' => 20,
        ],
    ])]
    protected ?int $id = null;

    #[Struct([
        self::COLUMN_NAME => '公司 ID',
        self::COLUMN_STRUCT => [
            'type_name' => 'bigint',
            'type_length' => 20,
        ],
    ])]
    protected ?int $companyId = null;

    #[Struct([
        self::COLUMN_NAME => '用户 ID',
        self::COLUMN_STRUCT => [
            'type_name' => 'bigint',
            'type_length' => 20,
        ],
    ])]
    protected ?int $userId = null;

    #[Struct([
        self::COLUMN_NAME => '类型 1=成员;2=收藏;3=关注;',
        self::ENUM_CLASS => ProjectUserTypeEnum::class,
        self::COLUMN_STRUCT => [
            'type_name' => 'tinyint',
            'type_length' => 1,
        ],
    ])]
    protected ?int $type = null;

    #[Struct([
        self::COLUMN_NAME => '扩展类型 1=成员;2=管理员;',
        self::ENUM_CLASS => ProjectUserExtendTypeEnum::class,
        self::COLUMN_STRUCT => [
            'type_name' => 'tinyint',
            'type_length' => 1,
        ],
    ])]
    protected ?int $extendType = null;

    #[Struct([
        self::COLUMN_NAME => '数据类型 1=项目;2=问题;',
        self::ENUM_CLASS => ProjectUserDataTypeEnum::class,
        self::COLUMN_STRUCT => [
            'type_name' => 'tinyint',
            'type_length' => 1,
        ],
    ])]
    protected ?int $dataType = null;

    #[Struct([
        self::COLUMN_NAME => '数据 ID',
        self::COLUMN_STRUCT => [
            'type_name' => 'bigint',
            'type_length' => 20,
        ],
    ])]
    protected ?int $dataId = null;

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
}
