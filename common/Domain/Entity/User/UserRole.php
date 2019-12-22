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

use Leevel\Database\Ddd\Entity;

/**
 * 用户角色.
 */
class UserRole extends Entity
{
    /**
     * Database table.
     *
     * @var string
     */
    const TABLE = 'user_role';

    /**
     * Primary key.
     *
     * @var string
     */
    const ID = 'id';

    /**
     * Auto increment.
     *
     * @var null
     */
    const AUTO = null;

    /**
     * Entity struct.
     *
     * - id
     *                   comment: ID  type: int(11) unsigned  null: false
     *                   key: PRI  default: null  extra: auto_increment
     * - user_id
     *                   comment: 用户 ID  type: int(11) unsigned  null: false
     *                   key: MUL  default: 0  extra:
     * - role_id
     *                   comment: 角色 ID  type: int(11) unsigned  null: false
     *                   key:   default: 0  extra:
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
        'user_id' => [
        ],
        'role_id' => [
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
    ];

    /**
     * Soft delete column.
     *
     * @var string
     */
    const DELETE_AT = 'delete_at';

    /**
     * Prop data.
     *
     * @var array
     */
    private array $data = [];

    /**
     * Database connect.
     *
     * @var mixed
     */
    private static $connect;

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
     *
     * @param mixed $connect
     */
    public static function withConnect($connect): void
    {
        static::$connect = $connect;
    }

    /**
     * Get database connect.
     */
    public static function connect()
    {
        return static::$connect;
    }
}
