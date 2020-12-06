<?php

declare(strict_types=1);

namespace Demo;

/**
 * @OA\Schema(
 *     title="Demo model",
 *     description="Demo model",
 * )
 */
class Demo
{
    /**
     * @OA\Property(
     *     title="ID",
     *     default=1,
     *     description="ID",
     * )
     *
     * @var int
     */
    private $id;

    /**
     * @OA\Property(
     *     description="Name",
     *     title="Name",
     * )
     *
     * @var string
     */
    private $name;
}
