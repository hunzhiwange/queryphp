<?php

declare(strict_types=1);

/*
 * This file is part of the forcodepoem package.
 *
 * The PHP Application Created By Code Poem. <Query Yet Simple>
 * (c) 2018-2099 http://forcodepoem.com All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Common\Domain\Entity;

use Common\Infra\Repository\Permission as RepositoryPermission;
use Leevel\Database\Ddd\Entity;

/**
 * Permission.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2018.11.20
 *
 * @version 1.0
 */
class Permission extends Entity
{
    /**
     * 仓储.
     *
     * @var string
     */
    const REPOSITORY = RepositoryPermission::class;

    /**
     * database table.
     *
     * @var string
     */
    const TABLE = 'permission';

    /**
     * primary key.
     *
     * @var string
     */
    const ID = 'id';

    /**
     * auto increment.
     *
     * @var null|array|string
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
        'pid'      => [],
        'name'     => [],
        'identity' => [],
        'status'   => [
            self::ENUM => [
                '0' => '禁用',
                '1' => '启用',
            ],
        ],
        'create_at'     => [],
        'resource'      => [
            self::MANY_MANY     => Resource::class,
            'middle_entity'     => PermissionResource::class,
            'source_key'        => 'id',
            'target_key'        => 'id',
            'middle_source_key' => 'permission_id',
            'middle_target_key' => 'resource_id',
        ],
    ];

    /**
     * id.
     *
     * @var int
     */
    private $id;

    /**
     * 父级 ID.
     *
     * @var int
     */
    private $pid;

    /**
     * 权限名字.
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
     * 资源.
     *
     * @var \Leevel\Collection\Collection
     */
    private $resource;

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
