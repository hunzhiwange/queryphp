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
 * Class Tag.
 *
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 *
 * @OA\Schema(
 *     type="object",
 *     description="Tag",
 *     title="Tag",
 *     @OA\Xml(
 *         name="Tag"
 *     )
 * )
 */
class Tag
{
    /**
     * @OA\Property(
     *     format="int64",
     *     description="ID",
     *     title="ID"
     * )
     *
     * @var int
     */
    private $id;

    /**
     * @OA\Property(
     *     description="Name",
     *     title="Name"
     * )
     *
     * @var string
     */
    private $name;
}
