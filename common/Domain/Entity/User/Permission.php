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
        'num'           => [],
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
     * soft delete column.
     *
     * @var string
     */
    const DELETE_AT = 'delete_at';

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
     * database connect.
     *
     * @var mixed
     */
    private static $leevelConnect;

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
     * 编号.
     *
     * @var string
     */
    private $num;

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
     * @param mixed $value
     *
     * @return $this
     */
    public function setter(string $prop, $value): IEntity
    {
        $this->{$this->realProp($prop)} = $value;

        return $this;
    }

    /**
     * getter.
     *
     * @return mixed
     */
    public function getter(string $prop)
    {
        return $this->{$this->realProp($prop)};
    }

    /**
     * set database connect.
     *
     * @param mixed $connect
     */
    public static function withConnect($connect): void
    {
        static::$leevelConnect = $connect;
    }

    /**
     * get database connect.
     */
    public static function connect()
    {
        return static::$leevelConnect;
    }
}
