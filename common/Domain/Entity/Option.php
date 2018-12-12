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
     * @string
     */
    const TABLE = 'option';

    /**
     * primary key.
     *
     * @string|null
     */
    const ID = 'name';

    /**
     * auto increment.
     *
     * @string|null
     */
    const AUTO = null;

    /**
     * entity struct.
     *
     * @array
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
