<?php

declare(strict_types=1);

namespace App\Domain\Entity\Product;

use Leevel\Database\Ddd\Entity;
use Leevel\Database\Ddd\Struct;

/**
 * base_brand.
 */
final class BaseBrand extends Entity
{
    /**
     * Database table.
     */
    public const TABLE = 'base_brand';

    /**
     * Primary key.
     */
    public const ID = 'brand_id';

    /**
     * Auto increment.
     */
    public const AUTO = 'brand_id';

    #[Struct([
        self::COLUMN_NAME => 'ID',
        self::READONLY => true,
        self::COLUMN_STRUCT => [
            'type_name' => 'int',
            'type_length' => 10,
        ],
    ])]
    protected ?int $brandId = null;

    #[Struct([
        self::COLUMN_NAME => '公司ID',
        self::COLUMN_STRUCT => [
            'type_name' => 'int',
            'type_length' => 10,
        ],
    ])]
    protected ?int $companyId = null;

    #[Struct([
        self::COLUMN_NAME => '状态',
        self::COLUMN_STRUCT => [
            'type_name' => 'enum',
            'type_length' => ['T', 'F'],
        ],
    ])]
    protected ?string $status = null;

    #[Struct([
        self::COLUMN_NAME => '排序',
        self::COLUMN_STRUCT => [
            'type_name' => 'int',
            'type_length' => 8,
        ],
    ])]
    protected ?int $orderNum = null;

    #[Struct([
        self::COLUMN_NAME => '编号',
        self::COLUMN_STRUCT => [
            'type_name' => 'varchar',
            'type_length' => 30,
        ],
    ])]
    protected ?string $brandNum = null;

    #[Struct([
        self::COLUMN_NAME => '名称',
        self::COLUMN_STRUCT => [
            'type_name' => 'varchar',
            'type_length' => 30,
        ],
    ])]
    protected ?string $brandName = null;

    #[Struct([
        self::COLUMN_NAME => 'LOGO',
        self::COLUMN_STRUCT => [
            'type_name' => 'varchar',
            'type_length' => 130,
        ],
    ])]
    protected ?string $brandLogo = null;

    #[Struct([
        self::COLUMN_NAME => '介绍',
        self::COLUMN_STRUCT => [
            'type_name' => 'text',
            'type_length' => null,
        ],
    ])]
    protected ?string $brandAbout = null;

    #[Struct([
        self::COLUMN_NAME => '更新时间',
        self::COLUMN_STRUCT => [
            'type_name' => 'timestamp',
            'type_length' => null,
        ],
    ])]
    protected ?string $updateDate = null;

    #[Struct([
        self::COLUMN_NAME => '创建时间',
        self::COLUMN_STRUCT => [
            'type_name' => 'timestamp',
            'type_length' => null,
        ],
    ])]
    protected ?string $createDate = null;

    #[Struct([
        self::COLUMN_NAME => '品牌首字母',
        self::COLUMN_STRUCT => [
            'type_name' => 'varchar',
            'type_length' => 30,
        ],
    ])]
    protected ?string $brandLetter = null;

    #[Struct([
        self::COLUMN_NAME => 'SEO关键字',
        self::COLUMN_STRUCT => [
            'type_name' => 'varchar',
            'type_length' => 30,
        ],
    ])]
    protected ?string $seoKeywords = null;
}
