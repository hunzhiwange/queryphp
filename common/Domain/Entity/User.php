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
     * @var string
     */
    const TABLE = 'user';

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
        'name'      => [],
        'identity'  => [],
        'password'  => [
            'show_prop_black' => true,
        ],
        'email'     => [],
        'mobile'    => [],
        'status'    => [
            self::ENUM => [
                '0' => '禁用',
                '1' => '启用',
            ],
        ],
        'create_at' => [],
        'role'      => [
            self::MANY_MANY     => Role::class,
            'middle_entity'     => UserRole::class,
            'source_key'        => 'id',
            'target_key'        => 'id',
            'middle_source_key' => 'user_id',
            'middle_target_key' => 'role_id',
        ],
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
     * 唯一标识符.
     *
     * @var string
     */
    private $identity;

    /**
     * 密码.
     *
     * @var string
     */
    private $password;

    /**
     * 电子邮件.
     *
     * @var string
     */
    private $email;

    /**
     * 手机号.
     *
     * @var string
     */
    private $mobile;

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
     * 角色.
     *
     * @var string
     */
    private $role;

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
