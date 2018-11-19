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

use Leevel\Database\Ddd\Entity;

/**
 * User.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2018.11.08
 *
 * @version 1.0
 */
class User extends Entity
{
    /**
     * database table.
     *
     * @string
     */
    const TABLE = 'user';

    /**
     * primary key.
     *
     * @string|null
     */
    const ID = 'id';

    /**
     * auto increment.
     *
     * @string|null
     */
    const AUTO = 'id';

    /**
     * entity struct.
     *
     * @array
     */
    const STRUCT = [
        'id' => [
            'readonly' => true,
        ],
        'name'      => [],
        'password'  => [],
        'status'    => [],
        'create_at' => [],
    ];

    /**
     * id.
     *
     * @var int
     */
    private $id;

    /**
     * 用户名字.
     *
     * @var string
     */
    private $name;

    /**
     * 密码.
     *
     * @var string
     */
    private $password;

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
