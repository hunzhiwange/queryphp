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
use Leevel\Database\Ddd\IEntity;

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
            self::READONLY => true,
        ],
        'pid'           => [],
        'name'          => [],
        'identity'      => [],
        'status'        => [],
        'create_at'     => [],
        'update_at'     => [
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
     * 状态值.
     *
     * @var array
     */
    const STATUS_ENUM = [
        'disable' => [0, '禁用'],
        'enable'  => [1, '启用'],
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
     * 更新时间.
     *
     * @var string
     */
    private $updateAt;

    /**
     * 删除时间 0=未删除;大于0=删除时间;.
     *
     * @var int
     */
    private $deleteAt;

    /**
     * 创建账号.
     *
     * @var int
     */
    private $createAccount;

    /**
     * 更新账号.
     *
     * @var int
     */
    private $updateAccount;

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
    public function setter(string $prop, $value): IEntity
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
