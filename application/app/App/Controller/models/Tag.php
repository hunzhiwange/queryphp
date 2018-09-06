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

namespace Petstore30;

/**
 * Class Tag.
 *
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 *
 * @OAS\Schema(
 *     type="object",
 *     description="Tag",
 *     title="Tag",
 *     @OAS\Xml(
 *         name="Tag"
 *     )
 * )
 */
class Tag
{
    /**
     * @OAS\Property(
     *     format="int64",
     *     description="ID",
     *     title="ID"
     * )
     *
     * @var int
     */
    private $id;

    /**
     * @OAS\Property(
     *     description="Name",
     *     title="Name"
     * )
     *
     * @var string
     */
    private $name;
}
