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

namespace Petstore30;

/**
 * Class Category.
 *
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 *
 * @OA\Schema(
 *     type="object",
 *     description="Pets Category",
 *     title="Pets Category",
 *     @OA\Xml(
 *         name="Category"
 *     )
 * )
 */
class Category
{
    /**
     * @OA\Property(
     *     title="ID",
     *     description="ID",
     *     format="int64",
     * )
     *
     * @var int
     */
    private $id;

    /**
     * @OA\Property(
     *     title="Category name",
     *     description="Category name"
     * )
     *
     * @var string
     */
    private $name;
}
