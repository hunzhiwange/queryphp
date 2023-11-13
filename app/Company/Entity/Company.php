<?php

declare(strict_types=1);

namespace App\Company\Entity;

use Leevel\Database\Ddd\Entity;
use Leevel\Database\Ddd\Struct;

/**
 * 公司.
 */
final class Company extends Entity
{
    public const CONNECT = 'common';

    /**
     * Database table.
     */
    public const TABLE = 'company';

    /**
     * Database table name.
     */
    public const TABLE_NAME = '公司';

    /**
     * Primary key.
     */
    public const ID = 'id';

    /**
     * Unique Index.
     */
    public const UNIQUE_INDEX = [
        'PRIMARY' => [
            'field' => ['id'],
            'comment' => 'ID',
        ],
        'uniq_company_id' => [
            'field' => ['company_id'],
            'comment' => '公司编号',
        ],
    ];

    /**
     * Auto increment.
     */
    public const AUTO = 'id';

    /**
     * Soft delete column.
     */
    public const DELETE_AT = 'delete_at';

    #[Struct([
        self::COLUMN_NAME => '公司ID',
        self::READONLY => true,
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'default' => null,
        ],
    ])]
    protected ?int $id = null;

    #[Struct([
        self::COLUMN_NAME => '平台ID',
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'default' => 0,
        ],
    ])]
    protected ?int $platformId = null;

    #[Struct([
        self::COLUMN_NAME => '编号',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'default' => '',
            'length' => 30,
        ],
    ])]
    protected ?string $num = null;

    #[Struct([
        self::COLUMN_NAME => '名称',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'default' => '',
            'length' => 50,
        ],
    ])]
    protected ?string $name = null;

    #[Struct([
        self::COLUMN_NAME => '公司全称',
        self::COLUMN_STRUCT => [
            'type' => 'char',
            'default' => '',
            'length' => 100,
        ],
    ])]
    protected ?string $fullName = null;

    #[Struct([
        self::COLUMN_NAME => '状态',
        self::COLUMN_COMMENT => '0=禁用;1=启用;',
        self::ENUM_CLASS => CompanyStatusEnum::class,
        self::COLUMN_STRUCT => [
            'type' => 'tinyint',
            'default' => 1,
        ],
    ])]
    protected ?int $status = null;

    #[Struct([
        self::COLUMN_NAME => '营业执照号',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'default' => '',
            'length' => 20,
        ],
    ])]
    protected ?string $businessLicense = null;

    #[Struct([
        self::COLUMN_NAME => '法人代表',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'default' => '',
            'length' => 20,
        ],
    ])]
    protected ?string $legalPerson = null;

    #[Struct([
        self::COLUMN_NAME => '法人手机',
        self::COLUMN_STRUCT => [
            'type' => 'char',
            'default' => '',
            'length' => 11,
        ],
    ])]
    protected ?string $legalMobile = null;

    #[Struct([
        self::COLUMN_NAME => '联系电话',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'default' => '',
            'length' => 50,
        ],
    ])]
    protected ?string $phone = null;

    #[Struct([
        self::COLUMN_NAME => '传真',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'default' => '',
            'length' => 20,
        ],
    ])]
    protected ?string $fax = null;

    #[Struct([
        self::COLUMN_NAME => '地区',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'default' => '',
            'length' => 50,
        ],
    ])]
    protected ?string $address = null;

    #[Struct([
        self::COLUMN_NAME => '网站',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'default' => '',
            'length' => 50,
        ],
    ])]
    protected ?string $webUrl = null;

    #[Struct([
        self::COLUMN_NAME => 'logo',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'default' => '',
            'length' => 200,
        ],
    ])]
    protected ?string $logo = null;

    #[Struct([
        self::COLUMN_NAME => '介绍',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'default' => '',
            'length' => 1024,
        ],
    ])]
    protected ?string $about = null;

    #[Struct([
        self::COLUMN_NAME => '开通时间',
        self::COLUMN_STRUCT => [
            'type' => 'date',
            'default' => '1970-01-01',
        ],
    ])]
    protected ?string $beginDate = null;

    #[Struct([
        self::COLUMN_NAME => '到期时间',
        self::COLUMN_STRUCT => [
            'type' => 'date',
            'default' => '1970-01-01',
        ],
    ])]
    protected ?string $endDate = null;

    #[Struct([
        self::COLUMN_NAME => '邮箱',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'default' => '',
            'length' => 30,
        ],
    ])]
    protected ?string $email = null;

    #[Struct([
        self::COLUMN_NAME => '联系人',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'default' => '',
            'length' => 30,
        ],
    ])]
    protected ?string $contact = null;

    #[Struct([
        self::COLUMN_NAME => '产品版本',
        self::COLUMN_STRUCT => [
            'type' => 'tinyint',
            'default' => 1,
        ],
    ])]
    protected ?int $productVersion = null;

    #[Struct([
        self::COLUMN_NAME => '注册IP地址',
        self::COLUMN_STRUCT => [
            'type' => 'char',
            'default' => '0.0.0.0',
            'length' => 15,
        ],
    ])]
    protected ?string $registerIp = null;

    #[Struct([
        self::COLUMN_NAME => '是否是测试公司',
        self::COLUMN_COMMENT => '0=否;1=是;',
        self::COLUMN_STRUCT => [
            'type' => 'tinyint',
            'default' => 0,
        ],
    ])]
    protected ?int $isTestCompany = null;

    #[Struct([
        self::COLUMN_NAME => '细分扩展版本',
        self::COLUMN_STRUCT => [
            'type' => 'tinyint',
            'default' => 1,
        ],
    ])]
    protected ?int $extendedProductVersion = null;

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
        self::COLUMN_NAME => '删除时间',
        self::COLUMN_COMMENT => '0=未删除;大于0=删除时间;',
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
