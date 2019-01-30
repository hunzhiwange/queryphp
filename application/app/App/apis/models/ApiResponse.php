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
 * Class ApiResponse.
 *
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 *
 * @OA\Schema(
 *     type="object",
 *     description="Api response",
 *     title="Api response"
 * )
 */
class ApiResponse
{
    /**
     * @OA\Property(
     *     description="Code",
     *     title="Code",
     *     format="int32"
     * )
     *
     * @var int
     */
    private $code;

    /**
     * OAS\Property(
     *    description="Type",
     *    title="Type",
     * ).
     *
     * @var string
     */
    private $type;

    /**
     * @OA\Property(
     *     description="Message",
     *     title="Message"
     * )
     *
     * @var string
     */
    private $message;
}
