<?php

declare(strict_types=1);

namespace App\Domain\Entity\Base;

use Leevel\Database\Ddd\Entity;
use Leevel\Database\Ddd\Struct;

/**
 * company.
 */
final class Company extends Entity
{
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
     * Soft delete column.
     */
    public const DELETE_AT = 'delete_at';

    #[Struct([
        self::COLUMN_NAME => '公司 ID',
        self::READONLY => true,
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'length' => 20,
        ],
    ])]
    protected ?int $id = null;

    #[Struct([
        self::COLUMN_NAME => '名称',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'length' => 50,
        ],
    ])]
    protected ?string $name = null;

    #[Struct([
        self::COLUMN_NAME => '编号',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'length' => 30,
        ],
    ])]
    protected ?string $num = null;

    #[Struct([
        self::COLUMN_NAME => '公司全称',
        self::COLUMN_STRUCT => [
            'type' => 'char',
            'length' => 20,
        ],
    ])]
    protected ?string $fullName = null;

    #[Struct([
        self::COLUMN_NAME => '状态 0=禁用;1=启用;',
        self::ENUM_CLASS => CompanyStatusEnum::class,
        self::COLUMN_STRUCT => [
            'type' => 'tinyint',
            'length' => 1,
        ],
    ])]
    protected ?int $status = null;

    #[Struct([
        self::COLUMN_NAME => '营业执照号',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'length' => 20,
        ],
    ])]
    protected ?string $businessLicense = null;

    #[Struct([
        self::COLUMN_NAME => '法人代表',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'length' => 20,
        ],
    ])]
    protected ?string $legalPerson = null;

    #[Struct([
        self::COLUMN_NAME => '法人手机',
        self::COLUMN_STRUCT => [
            'type' => 'char',
            'length' => 11,
        ],
    ])]
    protected ?string $legalMobile = null;

    #[Struct([
        self::COLUMN_NAME => '联系电话',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'length' => 50,
        ],
    ])]
    protected ?string $phone = null;

    #[Struct([
        self::COLUMN_NAME => '传真',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'length' => 20,
        ],
    ])]
    protected ?string $fax = null;

    #[Struct([
        self::COLUMN_NAME => '地区',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'length' => 50,
        ],
    ])]
    protected ?string $address = null;

    #[Struct([
        self::COLUMN_NAME => '网站',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'length' => 50,
        ],
    ])]
    protected ?string $webUrl = null;

    #[Struct([
        self::COLUMN_NAME => 'logo',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'length' => 200,
        ],
    ])]
    protected ?string $logo = null;

    #[Struct([
        self::COLUMN_NAME => '介绍',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'length' => 1024,
        ],
    ])]
    protected ?string $about = null;

    #[Struct([
        self::COLUMN_NAME => '开通时间',
        self::COLUMN_STRUCT => [
            'type' => 'date',
            'length' => null,
        ],
    ])]
    protected ?string $beginDate = null;

    #[Struct([
        self::COLUMN_NAME => '到期时间',
        self::COLUMN_STRUCT => [
            'type' => 'date',
            'length' => null,
        ],
    ])]
    protected ?string $endDate = null;

    #[Struct([
        self::COLUMN_NAME => '邮箱',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'length' => 30,
        ],
    ])]
    protected ?string $email = null;

    #[Struct([
        self::COLUMN_NAME => '联系人',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'length' => 30,
        ],
    ])]
    protected ?string $contact = null;

    #[Struct([
        self::COLUMN_NAME => '产品版本',
        self::COLUMN_STRUCT => [
            'type' => 'tinyint',
            'length' => 1,
        ],
    ])]
    protected ?int $productVersion = null;

    #[Struct([
        self::COLUMN_NAME => '注册 IP 地址',
        self::COLUMN_STRUCT => [
            'type' => 'char',
            'length' => 15,
        ],
    ])]
    protected ?string $registerIp = null;

    #[Struct([
        self::COLUMN_NAME => '是否是测试公司 0=否;1=是;',
        self::COLUMN_STRUCT => [
            'type' => 'tinyint',
            'length' => 1,
        ],
    ])]
    protected ?int $isTestCompany = null;

    #[Struct([
        self::COLUMN_NAME => '相对于 product_version 的细分扩展版本',
        self::COLUMN_STRUCT => [
            'type' => 'tinyint',
            'length' => 1,
        ],
    ])]
    protected ?int $extendedProductVersion = null;

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
