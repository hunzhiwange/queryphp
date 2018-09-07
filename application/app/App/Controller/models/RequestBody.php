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
