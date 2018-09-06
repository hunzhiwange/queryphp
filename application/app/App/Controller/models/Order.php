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
 * Class Order.
 *
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 * @OAS\Schema(
 *     title="Order model",
 *     description="Order model",
 * )
 */
class Order
{
    /**
     * @OAS\Property(
     *     format="int64",
     *     title="ID",
     *     default=1,
     *     description="ID",
     * )
     *
     * @var int
     */
    private $id;

    /**
     * @OAS\Property(
     *     default=1,
     *     format="int64",
     *     description="Pet ID",
     *     title="Pet ID",
     * )
     *
     * @var int
     */
    private $petId;

    /**
     * @OAS\Property(
     *     default=12,
     *     format="in32",
     *     description="Quantity",
     *     title="Quantity",
     * )
     *
     * @var int
     */
    private $quantity;

    /**
     * @OAS\Property(
     *     default="2017-02-02 18:31:45",
     *     format="datetime",
     *     description="Shipping date",
     *     title="Shipping date",
     *     title="Pet ID",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $shipDate;

    /**
     * @OAS\Property(
     *     default="placed",
     *     title="Order status",
     *     description="Order status",
     *     enum={"placed", "approved", "delivered"},
     *     title="Pet ID",
     * )
     *
     * @var string
     */
    private $status;

    /**
     * @OAS\Property(
     *     default="false",
     *     format="int64",
     *     description="Complete status",
     *     title="Complete status",
     * )
     *
     * @var bool
     */
    private $complete;
}
