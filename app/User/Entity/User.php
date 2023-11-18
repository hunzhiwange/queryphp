<?php

declare(strict_types=1);

namespace App\User\Entity;

use App\Infra\Service\Support\ReadParams;
use App\User\Repository\User as RepositoryUser;
use Leevel\Database\Ddd\Entity;
use Leevel\Database\Ddd\EntityCollection;
use Leevel\Database\Ddd\Struct;
use Leevel\Validate\IValidator;

/**
 * 用户.
 */
final class User extends Entity
{
    public const CONNECT = 'common';

    /**
     * Database table.
     */
    public const TABLE = 'user';

    /**
     * Database table name.
     */
    public const TABLE_NAME = '用户';

    /**
     * Primary key.
     */
    public const ID = 'id';

    /**
     * Unique Index.
     */
    public const UNIQUE_INDEX = [
        'PRIMARY' => [
            'field' => ['id', 'Host', 'User'],
            'comment' => 'ID',
        ],
        'uniq_name' => [
            'field' => ['platform_id', 'name', 'delete_at', 'type'],
            'comment' => '登陆用户',
        ],
        'uniq_num' => [
            'field' => ['platform_id', 'num', 'delete_at', 'type'],
            'comment' => '编号',
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

    /**
     * 仓储.
     */
    public const REPOSITORY = RepositoryUser::class;

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
        self::COLUMN_NAME => '平台ID',
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'default' => 0,
        ],
    ])]
    protected ?int $platformId = null;

    #[Struct([
        self::COLUMN_NAME => '账号类型',
        self::COLUMN_COMMENT => '1=员工;2=客户;3=供应商;4=联营商;',
        self::ENUM_CLASS => UserTypeEnum::class,
        self::COLUMN_STRUCT => [
            'type' => 'tinyint',
            'default' => 1,
        ],
    ])]
    protected ?int $type = null;

    #[Struct([
        self::COLUMN_NAME => '账号子类型',
        self::ENUM_CLASS => UserSubTypeEnum::class,
        self::COLUMN_STRUCT => [
            'type' => 'tinyint',
            'default' => 1,
        ],
    ])]
    protected ?int $subType = null;

    #[Struct([
        self::COLUMN_NAME => '用户名字',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'default' => '',
            'length' => 64,
        ],
        self::COLUMN_VALIDATOR => [
            self::VALIDATOR_SCENES => 'required|chinese_alpha_num|max_length:50',
            'store' => null,
            'update' => null,
        ],
        self::META => [
            ReadParams::SEARCH_KEY_COLUMN => true,
        ],
    ])]
    protected ?string $name = null;

    #[Struct([
        self::COLUMN_NAME => '编号',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'default' => '',
            'length' => 64,
        ],
        self::COLUMN_VALIDATOR => [
            self::VALIDATOR_SCENES => 'required|alpha_dash|max_length:50',
            'store' => null,
            'update' => null,
        ],
        self::META => [
            ReadParams::SEARCH_KEY_COLUMN => true,
        ],
    ])]
    protected ?string $num = null;

    #[Struct([
        self::COLUMN_NAME => '密码',
        self::SHOW_PROP_BLACK => true,
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'default' => '',
            'length' => 255,
        ],
        self::COLUMN_VALIDATOR => [
            self::VALIDATOR_SCENES => 'required|min_length:6,max_length:30',
            'store' => null,
            ':update' => IValidator::OPTIONAL,
        ],
    ])]
    protected ?string $password = null;

    #[Struct([
        self::COLUMN_NAME => 'Email',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'default' => '',
            'length' => 100,
        ],
        self::COLUMN_VALIDATOR => [
            self::VALIDATOR_SCENES => [
                'email',
                IValidator::OPTIONAL_STRING,
            ],
            'store' => null,
            'update' => null,
            'update_info' => null,
        ],
    ])]
    protected ?string $email = null;

    #[Struct([
        self::COLUMN_NAME => '手机',
        self::COLUMN_STRUCT => [
            'type' => 'char',
            'default' => '',
            'length' => 11,
        ],
        self::META => [
            ReadParams::SEARCH_KEY_COLUMN => true,
        ],
        self::COLUMN_VALIDATOR => [
            self::VALIDATOR_SCENES => [
                'mobile',
                IValidator::OPTIONAL_STRING,
            ],
            'store' => null,
            'update' => null,
            'update_info' => null,
        ],
    ])]
    protected ?string $mobile = null;

    #[Struct([
        self::COLUMN_NAME => '状态',
        self::COLUMN_COMMENT => '0=禁用;1=启用;2:待审',
        self::ENUM_CLASS => UserStatusEnum::class,
        self::COLUMN_STRUCT => [
            'type' => 'tinyint',
            'default' => 1,
        ],
    ])]
    protected ?int $status = null;

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

    #[Struct([
        self::COLUMN_NAME => '联系人',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'default' => '',
            'length' => 30,
        ],
        self::META => [
            ReadParams::SEARCH_KEY_COLUMN => true,
        ],
    ])]
    protected ?string $contact = null;

    #[Struct([
        self::COLUMN_NAME => '备注',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'default' => '',
            'length' => 255,
        ],
    ])]
    protected ?string $remark = null;

    #[Struct([
        self::COLUMN_NAME => '电话',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'default' => '',
            'length' => 20,
        ],
        self::META => [
            ReadParams::SEARCH_KEY_COLUMN => true,
        ],
    ])]
    protected ?string $phone = null;

    #[Struct([
        self::COLUMN_NAME => '地址区域',
        self::COLUMN_STRUCT => [
            'type' => 'bigint',
            'default' => 0,
        ],
    ])]
    protected ?int $cityId = null;

    #[Struct([
        self::COLUMN_NAME => '联系地址',
        self::COLUMN_STRUCT => [
            'type' => 'varchar',
            'default' => '',
            'length' => 100,
        ],
    ])]
    protected ?string $address = null;

    #[Struct([
        self::MANY_MANY => Role::class,
        self::MIDDLE_ENTITY => UserRole::class,
        self::SOURCE_KEY => 'id',
        self::TARGET_KEY => 'id',
        self::MIDDLE_SOURCE_KEY => 'user_id',
        self::MIDDLE_TARGET_KEY => 'role_id',
    ])]
    protected ?EntityCollection $role = null;

    public static function repository(?Entity $entity = null): RepositoryUser
    {
        return parent::repository($entity);
    }

    public function beforeCreateEvent(): void
    {
        $this->withProp('password', self::repository()->createPassword($this->password));
    }

    public function beforeUpdateEvent(): void
    {
        if (isset($this->password)) {
            $this->beforeCreateEvent();
        }
    }
}
