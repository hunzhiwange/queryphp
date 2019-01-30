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
 * RolePermission.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2019.01.13
 *
 * @version 1.0
 */
class RolePermission extends Entity
{
    /**
     * database table.
     *
     * @var string
     */
    const TABLE = 'role_permission';

    /**
     * primary key.
     *
     * @var array
     */
    const ID = ['role_id', 'permission_id'];

    /**
     * auto increment.
     *
     * @var string
     */
    const AUTO = null;

    /**
     * entity struct.
     *
     * @var array
     */
    const STRUCT = [
        'role_id' => [
            'readonly' => true,
        ],
        'permission_id' => [
            'readonly' => true,
        ],
        'create_at' => [],
    ];

    /**
     * 角色 ID.
     *
     * @var int
     */
    private $roleId;

    /**
     * 权限 ID.
     *
     * @var int
     */
    private $permissionId;

    /**
     * 创建时间.
     *
     * @var string
     */
    private $createAt;

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
