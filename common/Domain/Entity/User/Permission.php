<?php

declare(strict_types=1);

/*
 * This file is part of the your app package.
 *
 * The PHP Application For Code Poem For You.
 * (c) 2018-2099 http://yourdomian.com All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Common\Domain\Entity\User;

use Common\Infra\Repository\User\Permission as RepositoryPermission;
use Leevel\Database\Ddd\Entity;

/**
 * 权限.
 */
class Permission extends Entity
{
    /**
     * Database table.
     *
     * @var string
     */
    const TABLE = 'permission';

    /**
     * Primary key.
     *
     * @var string
     */
    const ID = 'id';

    /**
     * Auto increment.
     *
     * @var string
     */
    const AUTO = 'id';

    /**
     * Entity struct.
     *
     * - id
     *                   comment: ID  type: int(11) unsigned  null: false
     *                   key: PRI  default: null  extra: auto_increment
     * - pid
     *                   comment: 父级 ID  type: int(11) unsigned  null: false
     *                   key: MUL  default: 0  extra:
     * - name
     *                   comment: 权限名字  type: varchar(64)  null: false
     *                   key:   default:   extra:
     * - num
     *                   comment: 编号  type: varchar(64)  null: false
     *                   key: MUL  default:   extra:
     * - status
     *                   comment: 状态 0=禁用;1=启用;  type: tinyint(4) unsigned  null: false
     *                   key:   default: 1  extra:
     * - create_at
     *                   comment: 创建时间  type: datetime  null: false
     *                   key:   default: CURRENT_TIMESTAMP  extra:
     * - update_at
     *                   comment: 更新时间  type: datetime  null: false
     *                   key:   default: CURRENT_TIMESTAMP  extra: on update CURRENT_TIMESTAMP
     * - delete_at
     *                   comment: 删除时间 0=未删除;大于0=删除时间;  type: bigint(20) unsigned  null: false
     *                   key:   default: 0  extra:
     * - create_account
     *                   comment: 创建账号  type: int(11) unsigned  null: false
     *                   key:   default: 0  extra:
     * - update_account
     *                   comment: 更新账号  type: int(11) unsigned  null: false
     *                   key:   default: 0  extra:
     *
     * @var array
     */
    const STRUCT = [
        'id' => [
            self::READONLY => true,
        ],
        'pid' => [
        ],
        'name' => [
        ],
        'num' => [
        ],
        'status' => [
        ],
        'create_at' => [
        ],
        'update_at' => [
            self::SHOW_PROP_BLACK => true,
        ],
        'delete_at' => [
            self::SHOW_PROP_BLACK => true,
        ],
        'create_account' => [
            self::SHOW_PROP_BLACK => true,
        ],
        'update_account' => [
            self::SHOW_PROP_BLACK => true,
        ],
        'resource'      => [
            self::MANY_MANY         => Resource::class,
            self::MIDDLE_ENTITY     => PermissionResource::class,
            self::SOURCE_KEY        => 'id',
            self::TARGET_KEY        => 'id',
            self::MIDDLE_SOURCE_KEY => 'permission_id',
            self::MIDDLE_TARGET_KEY => 'resource_id',
        ],
    ];

    /**
     * Soft delete column.
     *
     * @var string
     */
    const DELETE_AT = 'delete_at';

    /**
     * 仓储.
     *
     * @var string
     */
    const REPOSITORY = RepositoryPermission::class;

    /**
     * 状态值.
     *
     * @var array
     */
    const STATUS_ENUM = [
        'disable' => [0, '禁用'],
        'enable'  => [1, '启用'],
    ];

    /**
     * Prop data.
     *
     * @var array
     */
    private array $data = [];

    /**
     * Database connect.
     */
    private static ?string $connect = null;

    /**
     * Setter.
     *
     * @param mixed $value
     */
    public function setter(string $prop, $value): self
    {
        $this->data[$this->realProp($prop)] = $value;

        return $this;
    }

    /**
     * Getter.
     *
     * @return mixed
     */
    public function getter(string $prop)
    {
        return $this->data[$this->realProp($prop)] ?? null;
    }

    /**
     * Set database connect.
     */
    public static function withConnect(?string $connect = null): void
    {
        static::$connect = $connect;
    }

    /**
     * Get database connect.
     */
    public static function connect(): ?string
    {
        return static::$connect;
    }
}
