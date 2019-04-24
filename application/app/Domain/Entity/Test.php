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

namespace App\Domain\Entity;

use Leevel\Database\Ddd\Entity;
use Leevel\Database\Ddd\IEntity;

/**
 * Test.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2018.11.08
 *
 * @version 1.0
 */
class Test extends Entity
{
    /**
     * database table.
     *
     * @string
     */
    const TABLE = 'test';

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
        'name' => [],
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
    private $name;

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
