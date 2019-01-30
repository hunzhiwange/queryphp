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

namespace Common\Domain\Entity;

use Leevel\Database\Ddd\Entity;

/**
 * Role.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2018.11.20
 *
 * @version 1.0
 */
class Role extends Entity
{
    /**
     * database table.
     *
     * @var string
     */
    const TABLE = 'role';

    /**
     * primary key.
     *
     * @var string
     */
    const ID = 'id';

    /**
     * auto increment.
     *
     * @var string
     */
    const AUTO = 'id';

    /**
     * entity struct.
     *
     * @var array
     */
    const STRUCT = [
        'id' => [
            'readonly' => true,
        ],
        'name'     => [],
        'identity' => [],
        'status'   => [
            self::ENUM => [
                '0' => '禁用',
                '1' => '启用',
            ],
        ],
        'create_at'       => [],
        'permission'      => [
            self::MANY_MANY     => Permission::class,
            'middle_entity'     => RolePermission::class,
            'source_key'        => 'id',
            'target_key'        => 'id',
            'middle_source_key' => 'role_id',
            'middle_target_key' => 'permission_id',
        ],
    ];

    /**
     * id.
     *
     * @var int
     */
    private $id;

    /**
     * 角色名字.
     *
     * @var string
     */
    private $name;

    /**
     * 唯一标识符.
     *
     * @var string
     */
    private $identity;

    /**
     * 状态 0=禁用;1=启用;.
     *
     * @var int
     */
    private $status;

    /**
     * 创建时间.
     *
     * @var string
     */
    private $createAt;

    /**
     * 权限.
     *
     * @var \Leevel\Collection\Collection
     */
    private $permission;

    /**
     * setter.
     *
     * @param string $prop
     * @param mixed  $value
     *
     * @return $this
     */
    public function setter(string $prop, $value): Entity
    {
        $this->{$this->prop($prop)} = $value;

        return $this;
    }

    /**
     * getter.
     *
     * @param string $prop
     *
     * @return mixed
     */
    public function getter(string $prop)
    {
        return $this->{$this->prop($prop)};
    }
}
