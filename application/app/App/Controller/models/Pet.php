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
 * Class Pet.
 *
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 *
 * @OAS\Schema(
 *     description="Pet model",
 *     title="Pet model",
 *     type="object",
 *     required={"name", "photoUrls"},
 *     @OAS\Xml(
 *         name="Pet"
 *     )
 * )
 */
class Pet
{
    /**
     * @OAS\Property(
     *     format="int64",
     *     description="ID",
     *     title="ID",
     * )
     *
     * @var int
     */
    private $id;

    /**
     * @OAS\Property(
     *     description="Category relation",
     *     title="Category",
     * )
     *
     * @var \Petstore30\Category
     */
    private $category;

    /**
     * @OAS\Property(
     *     format="int64",
     *     description="Pet name",
     *     title="Pet name",
     * )
     *
     * @var int
     */
    private $name;

    /**
     * @OAS\Property(
     *     description="Photo urls",
     *     title="Photo urls",
     *     @OAS\Xml(
     *         name="photoUrl",
     *         wrapped=true
     *     ),
     *     @OAS\Items(
     *         type="string",
     *         default="images/image-1.png"
     *     )
     * )
     *
     * @var array
     */
    private $photoUrls;

    /**
     * @OAS\Property(
     *     description="Pet tags",
     *     title="Pet tags",
     *     @OAS\Xml(
     *         name="tag",
     *         wrapped=true
     *     ),
     * )
     *
     * @var \Petstore30\Tag[]
     */
    private $tags;
}
