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
    const          TABLE = 'app';

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
            'readonly'             => true,
        ],
        'identity'                   => [],
        'key'                        => [],
        'secret'                     => [],
        'create_at'                  => [],
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
    private $identity;

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
