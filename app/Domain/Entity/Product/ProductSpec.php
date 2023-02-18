<?php

declare(strict_types=1);

namespace App\Domain\Entity\Product;

use Leevel\Database\Ddd\Entity;
use Leevel\Database\Ddd\Struct;

/**
 * 规格参数组下的参数名.
 */
final class ProductSpec extends Entity
{
    /**
     * Database table.
     */
    public const TABLE = 'product_spec';

    /**
     * Primary key.
     */
    public const ID = 'id';

    /**
     * Auto increment.
     */
    public const AUTO = 'id';

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
        self::COLUMN_NAME => '公司 ID',
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'length' => 20,
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
        self::COLUMN_NAME => '商品规格分组编号',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'length' => 50,
        ],
    ])]
    protected ?string $groupId = null;

    #[Struct([
        self::COLUMN_NAME => '商品规格分组名字',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'length' => 50,
        ],
    ])]
    protected ?string $groupName = null;

    #[Struct([
        self::COLUMN_NAME => '商品规格分组0=否;1=是;',
        self::COLUMN_STRUCT => [
            'type' => 'tinyint',
            'length' => 1,
        ],
    ])]
    protected ?int $groupMain = null;

    #[Struct([
        self::COLUMN_NAME => '商品规格分组对应的商品存储字段',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'length' => 50,
        ],
    ])]
    protected ?string $groupSkuField = null;

    #[Struct([
        self::COLUMN_NAME => '商品规格分组类型 0=SKU规格;1=SPU属性;2=基础展示类属性;3=自定义类属性;',
        self::COLUMN_STRUCT => [
            'type' => 'tinyint',
            'length' => 1,
        ],
    ])]
    protected ?int $groupType = null;

    #[Struct([
        self::COLUMN_NAME => '商品规格分组是否支持搜索 0=否;1=是;',
        self::COLUMN_STRUCT => [
            'type' => 'tinyint',
            'length' => 1,
        ],
    ])]
    protected ?int $groupSearching = null;

    #[Struct([
        self::COLUMN_NAME => '商品规格名字',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'length' => 50,
        ],
    ])]
    protected ?string $name = null;

    #[Struct([
        self::COLUMN_NAME => '商品规格编号',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'length' => 50,
        ],
    ])]
    protected ?string $specId = null;

    #[Struct([
        self::COLUMN_NAME => '是否用于搜索过滤 0=否;1=是;',
        self::COLUMN_STRUCT => [
            'type' => 'tinyint',
            'length' => 1,
        ],
    ])]
    protected ?int $searching = null;
}
