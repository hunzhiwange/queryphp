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

//use queryyetsimple\mvc\iaggregate_root;

use Leevel\Database\Ddd\Entity;

class Test extends Entity
{
    /**
     * 类似 doctrine.
     *
     * @ORM\Table(name="user")
     */
    const TABLE = 'test';
    const AUTO_INCREMENT = 'id';
    const PRIMARY_KEY = [//存在复合主键
        'id',
    ];
    /** @ORM\Id @ORM\Column @ORM\GeneratedValue */
    const STRUCT = [
        'id' => [
            'name'           => 'id',
            'type'           => 'int',
            'length'         => 11,
            'primary_key'    => true,
            'auto_increment' => true,
            'default'        => null,
        ],
        'name' => [
            'name'           => 'name',
            'type'           => 'varchar',
            'length'         => 45,
            'primary_key'    => false,
            'auto_increment' => false,
            'default'        => null,
        ],
    ];

    protected $id;
    protected $name;
}
