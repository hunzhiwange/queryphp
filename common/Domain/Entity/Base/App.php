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

namespace Common\Domain\Entity\Base;

use Leevel\Database\Ddd\Entity;
use Leevel\Database\Ddd\IEntity;

/**
 * 应用实体.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2018.11.09
 *
 * @version 1.0
 */
class App extends Entity
{
    /**
     * table.
     *
     * @var string
     */
    const TABLE = 'app';

    /**
     * id.
     *
     * @var string
     */
    const ID = 'id';

    /**
     * auto.
     *
     * @var string
     */
    const AUTO = 'id';

    /**
     * struct.
     *
     * @var array
     */
    const STRUCT = [
        'id' => [
            self::READONLY => true,
        ],
        'num'       => [],
        'status'    => [],
        'key'       => [],
        'secret'    => [],
        'create_at' => [],
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
     * name.
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
     * key.
     *
     * @var string
     */
    private $key;

    /**
     * secret.
     *
     * @var string
     */
    private $secret;

    /**
     * create_at.
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
