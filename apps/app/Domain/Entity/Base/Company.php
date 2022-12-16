<?php

declare(strict_types=1);

namespace App\Domain\Entity\Base;

use Leevel\Database\Ddd\Entity;
use Leevel\Database\Ddd\GetterSetter;

/**
 * 公司.
 */
class Company extends Entity
{
    use GetterSetter;

    /**
     * Database table.
     */
    public const TABLE = 'company';

    /**
     * Primary key.
     */
    public const ID = 'id';

    /**
     * Auto increment.
     */
    public const AUTO = 'id';

    /**
     * Entity struct.
     *
     * - id
     *                             comment: 公司 ID  type: bigint(20) unsigned  null: false
     *                             key: PRI  default: null  extra: auto_increment
     * - name
     *                             comment: 名称  type: varchar(50)  null: false
     *                             key:   default:   extra:
     * - num
     *                             comment: 编号  type: varchar(30)  null: false
     *                             key:   default:   extra:
     * - full_name
     *                             comment: 公司全称  type: char(20)  null: false
     *                             key:   default:   extra:
     * - status
     *                             comment: 状态 0=禁用;1=启用;  type: tinyint(1) unsigned  null: false
     *                             key:   default: 1  extra:
     * - business_license
     *                             comment: 营业执照号  type: varchar(20)  null: false
     *                             key:   default:   extra:
     * - legal_person
     *                             comment: 法人代表  type: varchar(20)  null: false
     *                             key:   default:   extra:
     * - legal_mobile
     *                             comment: 法人手机  type: char(11)  null: false
     *                             key:   default:   extra:
     * - phone
     *                             comment: 联系电话  type: varchar(50)  null: false
     *                             key:   default:   extra:
     * - fax
     *                             comment: 传真  type: varchar(20)  null: false
     *                             key:   default:   extra:
     * - address
     *                             comment: 地区  type: varchar(50)  null: false
     *                             key:   default:   extra:
     * - web_url
     *                             comment: 网站  type: varchar(50)  null: false
     *                             key:   default:   extra:
     * - logo
     *                             comment: logo  type: varchar(200)  null: true
     *                             key:   default:   extra:
     * - about
     *                             comment: 介绍  type: varchar(1024)  null: false
     *                             key:   default:   extra:
     * - begin_date
     *                             comment: 开通时间  type: date  null: false
     *                             key:   default: 0000-00-00  extra:
     * - end_date
     *                             comment: 到期时间  type: date  null: false
     *                             key:   default: 0000-00-00  extra:
     * - email
     *                             comment: 邮箱  type: varchar(30)  null: false
     *                             key:   default:   extra:
     * - contact
     *                             comment: 联系人  type: varchar(30)  null: false
     *                             key:   default:   extra:
     * - product_version
     *                             comment: 产品版本  type: tinyint(1)  null: false
     *                             key:   default: 1  extra:
     * - regist_ip
     *                             comment: 注册 IP 地址  type: char(15)  null: false
     *                             key:   default: 0.0.0.0  extra:
     * - is_test_company
     *                             comment: 是否是测试公司 0=否;1=是;  type: tinyint(1) unsigned  null: false
     *                             key:   default: 0  extra:
     * - extended_product_version
     *                             comment: 相对于 product_version 的细分扩展版本  type: tinyint(1) unsigned  null: false
     *                             key:   default: 1  extra:
     * - create_at
     *                             comment: 创建时间  type: datetime  null: false
     *                             key:   default: CURRENT_TIMESTAMP  extra:
     * - update_at
     *                             comment: 更新时间  type: datetime  null: false
     *                             key:   default: CURRENT_TIMESTAMP  extra: on update CURRENT_TIMESTAMP
     * - delete_at
     *                             comment: 删除时间 0=未删除;大于0=删除时间;  type: bigint(20) unsigned  null: false
     *                             key:   default: 0  extra:
     * - create_account
     *                             comment: 创建账号  type: bigint(20) unsigned  null: false
     *                             key:   default: 0  extra:
     * - update_account
     *                             comment: 更新账号  type: bigint(20) unsigned  null: false
     *                             key:   default: 0  extra:
     * - version
     *                             comment: 操作版本号  type: bigint(20) unsigned  null: false
     *                             key:   default: 0  extra:
     */
    public const STRUCT = [
        'id' => [
            self::COLUMN_NAME => '公司 ID',
            self::READONLY    => true,
        ],
        'name' => [
            self::COLUMN_NAME => '名称',
        ],
        'num' => [
            self::COLUMN_NAME => '编号',
        ],
        'full_name' => [
            self::COLUMN_NAME => '公司全称',
        ],
        'status' => [
            self::COLUMN_NAME => '状态 0=禁用;1=启用;',
            self::ENUM_CLASS => CompanyStatusEnum::class,
        ],
        'business_license' => [
            self::COLUMN_NAME => '营业执照号',
        ],
        'legal_person' => [
            self::COLUMN_NAME => '法人代表',
        ],
        'legal_mobile' => [
            self::COLUMN_NAME => '法人手机',
        ],
        'phone' => [
            self::COLUMN_NAME => '联系电话',
        ],
        'fax' => [
            self::COLUMN_NAME => '传真',
        ],
        'address' => [
            self::COLUMN_NAME => '地区',
        ],
        'web_url' => [
            self::COLUMN_NAME => '网站',
        ],
        'logo' => [
            self::COLUMN_NAME => 'logo',
        ],
        'about' => [
            self::COLUMN_NAME => '介绍',
        ],
        'begin_date' => [
            self::COLUMN_NAME => '开通时间',
        ],
        'end_date' => [
            self::COLUMN_NAME => '到期时间',
        ],
        'email' => [
            self::COLUMN_NAME => '邮箱',
        ],
        'contact' => [
            self::COLUMN_NAME => '联系人',
        ],
        'product_version' => [
            self::COLUMN_NAME => '产品版本',
        ],
        'regist_ip' => [
            self::COLUMN_NAME => '注册 IP 地址',
        ],
        'is_test_company' => [
            self::COLUMN_NAME => '是否是测试公司 0=否;1=是;',
        ],
        'extended_product_version' => [
            self::COLUMN_NAME => '相对于 product_version 的细分扩展版本',
        ],
        'create_at' => [
            self::COLUMN_NAME => '创建时间',
        ],
        'update_at' => [
            self::COLUMN_NAME     => '更新时间',
        ],
        'delete_at' => [
            self::COLUMN_NAME     => '删除时间 0=未删除;大于0=删除时间;',
            self::SHOW_PROP_BLACK => true,
        ],
        'create_account' => [
            self::COLUMN_NAME     => '创建账号',
            self::SHOW_PROP_BLACK => true,
        ],
        'update_account' => [
            self::COLUMN_NAME     => '更新账号',
            self::SHOW_PROP_BLACK => true,
        ],
        'version' => [
            self::COLUMN_NAME => '操作版本号',
        ],
    ]; // END STRUCT

    /**
     * Soft delete column.
     */
    public const DELETE_AT = 'delete_at';
}
