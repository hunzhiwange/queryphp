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
 * Class Category.
 *
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 *
 * @OAS\Schema(
 *     type="object",
 *     description="Pets Category",
 *     title="Pets Category",
 *     @OAS\Xml(
 *         name="Category"
 *     )
 * )
 */
class Category
{
    /**
     * @OAS\Property(
     *     title="ID",
     *     description="ID",
     *     format="int64",
     * )
     *
     * @var int
     */
    private $id;

    /**
     * @OAS\Property(
     *     title="Category name",
     *     description="Category name"
     * )
     *
     * @var string
     */
    private $name;
}
