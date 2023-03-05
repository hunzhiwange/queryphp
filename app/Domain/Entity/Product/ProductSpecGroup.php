<?php

declare(strict_types=1);

namespace App\Domain\Entity\Product;

use Leevel\Database\Ddd\Entity;
use Leevel\Database\Ddd\Struct;
use Leevel\Validate\IValidator;

/**
 * 商品规格分组.
 */
final class ProductSpecGroup extends Entity
{
    /**
     * Database table.
     */
    public const TABLE = 'product_spec_group';

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
            'default' => null,
        ],
    ])]
    protected ?int $id = null;

    #[Struct([
        self::COLUMN_NAME => '公司ID',
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'default' => 0,
        ],
    ])]
    protected ?int $companyId = null;

    #[Struct([
        self::COLUMN_NAME => '商品分类编号',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'default' => '',
            'length' => 50,
        ],
    ])]
    protected ?string $categoryId = null;

    #[Struct([
        self::COLUMN_NAME => '模板分类',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'default' => '',
            'length' => 50,
        ],
    ])]
    protected ?string $template = null;

    #[Struct([
        self::COLUMN_NAME => '模板名字',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'default' => '',
            'length' => 50,
        ],
    ])]
    protected ?string $templateName = null;

    #[Struct([
        self::COLUMN_NAME => '商品规格分组编号',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'default' => '',
            'length' => 50,
        ],
        self::COLUMN_VALIDATOR => [
            self::VALIDATOR_SCENES => 'required|alpha_dash|max_length:20',
            ':update' => IValidator::OPTIONAL,
            'update_by_group_id' => null,
            'update_by_new' => 'required',
        ],
    ])]
    protected ?string $groupId = null;

    #[Struct([
        self::COLUMN_NAME => '商品规格分组名字',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'default' => '',
            'length' => 50,
        ],
        self::COLUMN_VALIDATOR => [
            self::VALIDATOR_SCENES => 'required|max_length:20',
            ':update_name' => IValidator::OPTIONAL,
        ],
    ])]
    protected ?string $groupName = null;

    #[Struct([
        self::COLUMN_NAME => '商品规格分组对应的商品存储字段',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'default' => '',
            'length' => 50,
        ],
    ])]
    protected ?string $groupSkuField = null;

    #[Struct([
        self::COLUMN_NAME => '商品规格分组类型 0=SKU规格;1=SPU属性;2=基础展示类属性;3=自定义类属性;',
        self::ENUM_CLASS => ProductSpecGroupGroupTypeEnum::class,
        self::COLUMN_STRUCT => [
            'type' => 'tinyint',
            'default' => 1,
        ],
    ])]
    protected ?int $groupType = null;

    #[Struct([
        self::COLUMN_NAME => '商品规格分组是否支持搜索 0=否;1=是;',
        self::ENUM_CLASS => ProductSpecGroupSearchingEnum::class,
        self::COLUMN_STRUCT => [
            'type' => 'tinyint',
            'default' => 0,
        ],
    ])]
    protected ?int $groupSearching = null;

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
        self::COLUMN_NAME => '删除时间 0=未删除;大于0=删除时间;',
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
