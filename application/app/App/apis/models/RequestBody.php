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
 * @OA\RequestBody(
 *     request="Pet",
 *     description="Pet object that needs to be added to the store",
 *     required=true,
 *     @OA\MediaType(
 *         mediaType="application/json",
 *         @OA\Schema(
 *             ref="#/components/schemas/Pet"
 *         )
 *     ),
 *     @OA\MediaType(
 *         mediaType="application/xml",
 *         @OA\Schema(
 *             ref="#/components/schemas/Pet"
 *         )
 *     )
 * )
 */
class Foobar
{
}

/**
 * @OA\RequestBody(
 *     request="UserArray",
 *     description="List of user object",
 *     required=true,
 *     @OA\MediaType(
 *         mediaType="application/json",
 *         @OA\Schema(
 *             type="array",
 *             @OA\Items(
 *                 ref="#/components/schemas/User"
 *             )
 *         )
 *     )
 * )
 */
class Foobar
{
}
