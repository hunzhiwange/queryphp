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
 * Class User.
 *
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 *
 * @OA\Schema(
 *     title="User model",
 *     description="User model",
 *     type="object"
 * )
 */
class User
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
     *     description="Username",
     *     title="Username",
     * )
     *
     * @var string
     */
    private $username;

    /**
     * @OA\Property(
     *     description="First name",
     *     title="First name",
     * )
     *
     * @var string
     */
    private $firstName;

    /**
     * @OA\Property(
     *     description="Last name",
     *     title="Last name",
     * )
     *
     * @var string
     */
    private $lastName;

    /**
     * @OA\Property(
     *     format="email",
     *     description="Email",
     *     title="Email",
     * )
     *
     * @var string
     */
    private $email;

    /**
     * @OA\Property(
     *     format="int64",
     *     description="Password",
     *     title="Password",
     *     maximum=255
     * )
     *
     * @var string
     */
    private $password;

    /**
     * @OA\Property(
     *     format="msisdn",
     *     description="Phone",
     *     title="Phone",
     * )
     *
     * @var string
     */
    private $phone;

    /**
     * @OA\Property(
     *     format="int32",
     *     description="User status",
     *     title="User status",
     * )
     *
     * @var int
     */
    private $userStatus;
}
