<?php

declare(strict_types=1);

namespace App\Domain\Entity\Product;

use Leevel\Database\Ddd\Entity;
use Leevel\Database\Ddd\Struct;

/**
 * 产品分类.
 */
final class ProductCategory extends Entity
{
    /**
     * Database table.
     */
    public const TABLE = 'product_category';

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
            'length' => 0,
        ],
    ])]
    protected ?int $id = null;

    #[Struct([
        self::COLUMN_NAME => '公司 ID',
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'length' => 0,
        ],
    ])]
    protected ?int $companyId = null;

    #[Struct([
        self::COLUMN_NAME => '商品分类编号',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'length' => 50,
        ],
    ])]
    protected ?string $categoryId = null;

    #[Struct([
        self::COLUMN_NAME => '父级分类 ID',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'length' => 50,
        ],
    ])]
    protected ?string $parentId = null;

    #[Struct([
        self::COLUMN_NAME => '商品分类名字',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'length' => 50,
        ],
    ])]
    protected ?string $name = null;

    #[Struct([
        self::COLUMN_NAME => '是否用于搜索过滤 0=否;1=是;',
        self::ENUM_CLASS => ProductCategorySearchingEnum::class,
        self::COLUMN_STRUCT => [
            'type' => 'tinyint',
            'length' => 0,
        ],
    ])]
    protected ?int $searching = null;

    #[Struct([
        self::COLUMN_NAME => '排序(ASC)',
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'length' => 0,
        ],
    ])]
    protected ?int $sort = null;

    #[Struct([
        self::COLUMN_NAME => '分类品牌(公司内部多个主品牌)',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'length' => 50,
        ],
    ])]
    protected ?string $brandId = null;

    #[Struct([
        self::COLUMN_NAME => '分类最大订购数量提醒',
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'length' => 0,
        ],
    ])]
    protected ?int $maxOrderNumber = null;

    #[Struct([
        self::COLUMN_NAME => '首字母',
        self::COLUMN_STRUCT => [
            'type' => 'char',
            'length' => 1,
        ],
    ])]
    protected ?string $letter = null;

    #[Struct([
        self::COLUMN_NAME => '大LOGO',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'length' => 255,
        ],
    ])]
    protected ?string $logoLarge = null;

    #[Struct([
        self::COLUMN_NAME => 'LOGO',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'length' => 255,
        ],
    ])]
    protected ?string $logoDefault = null;

    #[Struct([
        self::COLUMN_NAME => '小LOGO',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'length' => 255,
        ],
    ])]
    protected ?string $logoSmall = null;

    #[Struct([
        self::COLUMN_NAME => '创建时间',
        self::COLUMN_STRUCT => [
            'type' => 'datetime',
            'length' => 0,
        ],
    ])]
    protected ?string $createAt = null;

    #[Struct([
        self::COLUMN_NAME => '更新时间',
        self::COLUMN_STRUCT => [
            'type' => 'datetime',
            'length' => 0,
        ],
    ])]
    protected ?string $updateAt = null;

    #[Struct([
        self::COLUMN_NAME => '删除时间 0=未删除;大于0=删除时间;',
        self::SHOW_PROP_BLACK => true,
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'length' => 0,
        ],
    ])]
    protected ?int $deleteAt = null;

    #[Struct([
        self::COLUMN_NAME => '创建账号',
        self::SHOW_PROP_BLACK => true,
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'length' => 0,
        ],
    ])]
    protected ?int $createAccount = null;

    #[Struct([
        self::COLUMN_NAME => '更新账号',
        self::SHOW_PROP_BLACK => true,
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'length' => 0,
        ],
    ])]
    protected ?int $updateAccount = null;

    #[Struct([
        self::COLUMN_NAME => '操作版本号',
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'length' => 0,
        ],
    ])]
    protected ?int $version = null;
}
