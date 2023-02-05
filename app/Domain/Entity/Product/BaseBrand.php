<?php

declare(strict_types=1);

namespace App\Domain\Entity\Product;

use Leevel\Database\Ddd\Entity;
use Leevel\Database\Ddd\GetterSetter;

/**
 * base_brand.
 */
class BaseBrand extends Entity
{
    use GetterSetter;

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

    /**
     * Entity struct.
     *
     * - brand_id
     *                 comment: ID  type: int(10) unsigned  null: false
     *                 key: PRI  default: null  extra: auto_increment
     * - company_id
     *                 comment: 公司ID  type: int(10) unsigned  null: false
     *                 key: MUL  default: null  extra:
     * - status
     *                 comment: 状态  type: enum('T','F')  null: false
     *                 key:   default: T  extra:
     * - order_num
     *                 comment: 排序  type: int(8) unsigned  null: false
     *                 key: MUL  default: 500  extra:
     * - brand_num
     *                 comment: 编号  type: varchar(30)  null: false
     *                 key: MUL  default:   extra:
     * - brand_name
     *                 comment: 名称  type: varchar(30)  null: false
     *                 key:   default:   extra:
     * - brand_logo
     *                 comment: LOGO  type: varchar(130)  null: false
     *                 key:   default:   extra:
     * - brand_about
     *                 comment: 介绍  type: text  null: false
     *                 key:   default: null  extra:
     * - update_date
     *                 comment: 更新时间  type: timestamp  null: false
     *                 key:   default: CURRENT_TIMESTAMP  extra: on update CURRENT_TIMESTAMP
     * - create_date
     *                 comment: 创建时间  type: timestamp  null: false
     *                 key:   default: CURRENT_TIMESTAMP  extra:
     * - brand_letter
     *                 comment: 品牌首字母  type: varchar(30)  null: false
     *                 key:   default:   extra:
     * - seo_keywords
     *                 comment: SEO关键字  type: varchar(30)  null: false
     *                 key:   default: null  extra:
     */
    public const STRUCT = [
        'brand_id' => [
            self::COLUMN_NAME => 'ID',
            self::READONLY => true,
        ],
        'company_id' => [
            self::COLUMN_NAME => '公司ID',
        ],
        'status' => [
            self::COLUMN_NAME => '状态',
        ],
        'order_num' => [
            self::COLUMN_NAME => '排序',
        ],
        'brand_num' => [
            self::COLUMN_NAME => '编号',
        ],
        'brand_name' => [
            self::COLUMN_NAME => '名称',
        ],
        'brand_logo' => [
            self::COLUMN_NAME => 'LOGO',
        ],
        'brand_about' => [
            self::COLUMN_NAME => '介绍',
        ],
        'update_date' => [
            self::COLUMN_NAME => '更新时间',
        ],
        'create_date' => [
            self::COLUMN_NAME => '创建时间',
        ],
        'brand_letter' => [
            self::COLUMN_NAME => '品牌首字母',
        ],
        'seo_keywords' => [
            self::COLUMN_NAME => 'SEO关键字',
        ],
    ]; // END STRUCT
}
