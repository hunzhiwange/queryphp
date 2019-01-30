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
 * Class Pet.
 *
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 *
 * @OA\Schema(
 *     description="Pet model",
 *     title="Pet model",
 *     type="object",
 *     required={"name", "photoUrls"},
 *     @OA\Xml(
 *         name="Pet"
 *     )
 * )
 */
class Pet
{
    /**
     * @OA\Property(
     *     format="int64",
     *     description="ID",
     *     title="ID",
     * )
     *
     * @var int
     */
    private $id;

    /**
     * @OA\Property(
     *     description="Category relation",
     *     title="Category",
     * )
     *
     * @var \Petstore30\Category
     */
    private $category;

    /**
     * @OA\Property(
     *     format="int64",
     *     description="Pet name",
     *     title="Pet name",
     * )
     *
     * @var int
     */
    private $name;

    /**
     * @OA\Property(
     *     description="Photo urls",
     *     title="Photo urls",
     *     @OA\Xml(
     *         name="photoUrl",
     *         wrapped=true
     *     ),
     *     @OA\Items(
     *         type="string",
     *         default="images/image-1.png"
     *     )
     * )
     *
     * @var array
     */
    private $photoUrls;

    /**
     * @OA\Property(
     *     description="Pet tags",
     *     title="Pet tags",
     *     @OA\Xml(
     *         name="tag",
     *         wrapped=true
     *     ),
     * )
     *
     * @var \Petstore30\Tag[]
     */
    private $tags;
}
