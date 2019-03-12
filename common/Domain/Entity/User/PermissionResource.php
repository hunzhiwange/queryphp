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
 * PermissionResource.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2019.01.13
 *
 * @version 1.0
 */
class PermissionResource extends Entity
{
    /**
     * database table.
     *
     * @var string
     */
    const TABLE = 'permission_resource';

    /**
     * primary key.
     *
     * @var array
     */
    const ID = ['permission_id', 'resource_id'];

    /**
     * auto increment.
     *
     * @var null
     */
    const AUTO = null;

    /**
     * entity struct.
     *
     * @var array
     */
    const STRUCT = [
        'permission_id' => [
            'readonly' => true,
        ],
        'resource_id' => [
            'readonly' => true,
        ],
        'create_at' => [],
    ];

    /**
     * 权限 ID.
     *
     * @var int
     */
    private $permissionId;

    /**
     * 资源 ID.
     *
     * @var int
     */
    private $resourceId;

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
