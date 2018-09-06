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
 * Class User.
 *
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 *
 * @OAS\Schema(
 *     title="User model",
 *     description="User model",
 *     type="object"
 * )
 */
class User
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
     *     description="Username",
     *     title="Username",
     * )
     *
     * @var string
     */
    private $username;

    /**
     * @OAS\Property(
     *     description="First name",
     *     title="First name",
     * )
     *
     * @var string
     */
    private $firstName;

    /**
     * @OAS\Property(
     *     description="Last name",
     *     title="Last name",
     * )
     *
     * @var string
     */
    private $lastName;

    /**
     * @OAS\Property(
     *     format="email",
     *     description="Email",
     *     title="Email",
     * )
     *
     * @var string
     */
    private $email;

    /**
     * @OAS\Property(
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
     * @OAS\Property(
     *     format="msisdn",
     *     description="Phone",
     *     title="Phone",
     * )
     *
     * @var string
     */
    private $phone;

    /**
     * @OAS\Property(
     *     format="int32",
     *     description="User status",
     *     title="User status",
     * )
     *
     * @var int
     */
    private $userStatus;
}
