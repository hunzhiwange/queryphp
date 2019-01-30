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
 * Option.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2018.11.20
 *
 * @version 1.0
 */
class Option extends Entity
{
    /**
     * database table.
     *
     * @var string
     */
    const TABLE = 'option';

    /**
     * primary key.
     *
     * @var string
     */
    const ID = 'name';

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
        'name' => [
            'readonly' => true,
        ],
        'value'     => [],
        'create_at' => [
            'show_prop_black' => true,
        ],
    ];

    /**
     * 配置名.
     *
     * @var string
     */
    private $name;

    /**
     * 配置值.
     *
     * @var string
     */
    private $value;

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
